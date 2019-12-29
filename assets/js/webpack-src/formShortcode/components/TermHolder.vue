<template>
  <hide-box :heading="heading">
    <div :key="forceUpdateKey">
      <input type="text" v-model="searchTerm" :placeholder="extras.strings.search" class="wpcd-fs-w-full-important" />
      <!--     no search term display -->
      <ul
        v-show="isSearchEmpty && maxLengthCheck"
        class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade wpcd-fs-max-h-200 wpcd-fs-overflow-auto wpcd-fs-list-override wpcd-fs-w-full-important wpcd-fs-border wpcd-fs-mt-1"
      >
        <li v-for="term in treeView" :key="term.term_id" class="wpcd-fs-p-1" :title="generateTitleTree(term)">
          <term :key="term.term_id" :recursive="true" :term="term" @change="pushTerms" :terms="checkedTerms" />
        </li>
      </ul>

      <!--        search term display-->
      <transition-group
        tag="ul"
        class="wpcd-fs-max-h-200 wpcd-fs-overflow-auto wpcd-fs-list-override wpcd-fs-w-full-important wpcd-fs-border wpcd-fs-mt-1"
        name="wpcd-fs-transition-fade"
        v-show="!isSearchEmpty && maxLengthCheck"
      >
        <li v-for="term in searchFiltered" :key="term.term_id" class="wpcd-fs-p-1" :title="generateTitleTree(term)">
          <term :key="term.term_id" :recursive="false" :term="term" @change="pushTerms" :terms="checkedTerms" />
        </li>
      </transition-group>
      <div
        v-show="!maxLengthCheck"
        class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade wpcd-fs-w-full-important wpcd-fs-no-terms wpcd-fs-no-text wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-items-center wpcd-fs-h-full-important wpcd-fs-mt-1"
      >
        {{ extras.strings.nothing }}...
      </div>
      <term-insert
        v-if="termInsert"
        :heading="heading"
        :terms="hierarchicalTerms"
        :raw="extras.terms"
        :taxname="taxname"
        @createNewTerm="insertNewTerm"
        class="wpcd-fs-mt-1"
      />
    </div>
  </hide-box>
</template>
<script>
import Term from './Term';
import TermInsert from './TermInsert';
import HideBox from './HideBox';

export default {
  props: ['itemsPerPage', 'heading', 'sTerms', 'taxname', 'termsChecked', 'termInsert'],
  components: { HideBox, Term, TermInsert },
  data() {
    return {
      checkedTerms: [],
      newTermName: '',
      forceUpdateKey: 0,
      showTerms: false,
      searchTerm: '',
      maxLength: 0,
      terms: this.sTerms,
    };
  },
  watch: {
    checkedTerms() {
      this.$emit('termsChanged', this.taxname, this.checkedTerms);
    },
    terms() {
      this.parentChildRelation();
    },
  },
  created() {
    this.parentChildRelation();
    this.checkedTerms = this.termsChecked;
  },
  methods: {
    generateTitleTree(termObj) {
      const parentArray = [];

      const vm = this;
      function recursiveParent(parentId) {
        if (parentId !== 0) {
          const parent = vm.terms.filter(t => {
            return t.term_id === parentId;
          })[0];

          parentArray.push(parent.name);

          // inner recursive start point
          recursiveParent(parent.parent);
        }
      }

      // add term self name to the array to maintain the string format of 'other_parent > parent > self'
      if (termObj.parent !== 0) {
        parentArray.push(termObj.name);
      }

      // recursive start point
      recursiveParent(termObj.parent);

      return parentArray.reverse().join(' > ');
    },
    checkedSort(arr) {
      return arr.sort((a, b) => {
        const aInc = this.isChecked(a);
        const bInc = this.isChecked(b);

        return bInc - aInc;
      });
    },
    searchFocus() {
      this.currentPage = 1;
    },
    insertNewTerm(termObj) {
      const term = JSON.stringify({ [this.taxname]: termObj });
      const formData = new FormData();

      formData.set('new_term', term);
      formData.set('nonce', this.extras.nonce);
      formData.set('action', this.extras.form_action);

      this.resource
        .save(formData)
        .then(
          resp => resp.json(),
          // eslint-disable-next-line no-console
          resp => console.log(resp)
        )
        .then(j => {
          this.terms = j.terms[this.taxname];
          this.extras.terms[this.taxname] = j.terms[this.taxname];
        });
    },
    pushTerms(val) {
      const parsedVal = parseInt(val, 10);
      const index = this.checkedTerms.indexOf(parsedVal);
      if (index >= 0) {
        this.checkedTerms.splice(index, 1);
      } else {
        this.checkedTerms.push(parsedVal);
      }
    },
    isChecked(term) {
      return this.checkedTerms.includes(term.term_id);
    },
    parentChildRelation() {
      this.terms.map(t => {
        // eslint-disable-next-line no-param-reassign
        t.child = [];
      });
      const vm = this;
      this.terms.map(f => {
        if (f.parent !== 0) {
          const parentId = f.parent;
          vm.terms.map(l => {
            if (l.term_id === parentId) {
              l.child.push(f);
            }
          });
        }
      });
    },
  },
  computed: {
    isSearchEmpty() {
      return this.searchTerm === '';
    },
    maxLengthCheck() {
      return this.maxLength !== 0;
    },
    hierarchicalTerms() {
      this.parentChildRelation();
      const filtered = this.terms.filter(t => {
        return t.parent === 0;
      });

      return { ...filtered };
    },
    treeView() {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.forceUpdateKey += 1;

      // deep clone array objects and child property objects to break the object reference bond with raw terms
      const sideObject = this.terms.map(t => {
        return JSON.parse(JSON.stringify(t));
      });

      // first pass to remove checked terms and unchecked terms with unchecked/checked parents to display as tree
      const filtered = sideObject.filter(s => {
        if (this.isChecked(s) === true) {
          // eslint-disable-next-line no-param-reassign
          s.child = [];
          return true;
        }
        if (s.parent === 0) {
          return true;
        }
        const parentObj = this.terms.filter(p => p.term_id === s.parent)[0];
        if (parentObj === undefined || (parentObj && this.isChecked(parentObj) === false)) {
          return false;
        }
        return true;
      });

      this.checkedSort(filtered);

      const vm = this;
      function deepFilter(obj) {
        if (vm.isChecked(obj) === true) {
          return false;
        }
        if (obj.child.length > 0) {
          // eslint-disable-next-line no-param-reassign
          obj.child = obj.child.filter(deepFilter);
        }
        return true;
      }

      // second pass to remove checked objects from child property array
      filtered.forEach(s => {
        if (s.child) {
          if (s.child.length > 0) {
            // eslint-disable-next-line no-param-reassign
            s.child = s.child.filter(deepFilter);
          }
        }
      });

      return filtered;
    },
    searchFiltered() {
      const sideObject = [...this.terms];

      // sort according to checked status
      this.checkedSort(sideObject);

      // filter search term
      const filteredObj = sideObject.filter(a => {
        return a.name.includes(this.searchTerm);
      });

      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.maxLength = filteredObj.length;

      return filteredObj;
    },
  },
};
</script>
