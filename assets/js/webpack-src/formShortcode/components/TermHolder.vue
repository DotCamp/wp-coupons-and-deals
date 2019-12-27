<template>
  <hide-box :heading="heading">
    <div :key="forceUpdateKey">
      <input
        type="text"
        v-model="searchTerm"
        :placeholder="extras.strings.search"
        class="wpcd-fs-w-full-important"
        @focus="searchFocus()"
      />
      <transition-group
        tag="ul"
        class="wpcd-fs-list-override wpcd-fs-w-full-important wpcd-fs-border wpcd-fs-mt-1"
        name="wpcd-fs-transition-fade"
        v-show="maxLengthCheck"
      >
        <li v-for="term in checkedSort" :key="term.name" class="wpcd-fs-p-1">
          <term :recursive="false" :term="term" @change="pushTerms" :terms="checkedTerms" />
        </li>
      </transition-group>
      <div
        v-show="!maxLengthCheck"
        class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade wpcd-fs-w-full-important wpcd-fs-no-terms wpcd-fs-no-text wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-items-center wpcd-fs-h-full-important wpcd-fs-mt-1"
      >
        {{ extras.strings.nothing }}...
      </div>
      <div class="wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-w-full-important">
        <pagination v-model="currentPage" :itemperpage="itemsPerPage" :max="maxLength" class="wpcd-fs-mt-1" />
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
import Pagination from './Pagination';

export default {
  props: ['itemsPerPage', 'heading', 'terms', 'taxname', 'termsChecked', 'termInsert'],
  components: { HideBox, Term, TermInsert, Pagination },
  data() {
    return {
      checkedTerms: [],
      newTermName: '',
      forceUpdateKey: 0,
      showTerms: false,
      searchTerm: '',
      currentPage: 1,
      maxLength: 0,
    };
  },
  watch: {
    checkedTerms() {
      this.$emit('termsChanged', this.taxname, this.checkedTerms);
    },
  },
  created() {
    this.parentChildRelation();
    this.checkedTerms = this.termsChecked;
  },
  methods: {
    searchFocus() {
      this.currentPage = 1;
      // this.forceUpdateKey += 1;
    },
    insertNewTerm(termObj) {
      if (!this.store.newTerms) {
        this.store.newTerms = {};
      }

      if (!this.store.newTerms[this.taxname]) {
        this.store.newTerms[this.taxname] = [];
      }

      this.store.newTerms[this.taxname].push(termObj);
      this.terms.push(termObj);
      this.parentChildRelation();
    },
    pushTerms(val) {
      const index = this.checkedTerms.indexOf(val);
      if (index >= 0) {
        this.checkedTerms.splice(index, 1);
      } else {
        this.checkedTerms.push(val);
      }
    },
    isChecked(name) {
      return this.checkedTerms.includes(name);
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
    maxLengthCheck() {
      return this.maxLength !== 0;
    },
    hierarchicalTerms() {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.forceUpdateKey += 1;
      this.parentChildRelation();
      const filtered = this.terms.filter(t => {
        return t.parent === 0;
      });
      return { ...filtered };
    },
    checkedSort() {
      const sideObject = [...this.terms];

      // sort according to checked status
      sideObject.sort((a, b) => {
        const aInc = this.termsChecked.includes(a.name);
        const bInc = this.termsChecked.includes(b.name);

        return bInc - aInc;
      });

      // filter search term
      const filteredObj = sideObject.filter(a => {
        return a.name.includes(this.searchTerm);
      });

      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.maxLength = filteredObj.length;

      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const paginatedObj = filteredObj.slice(startIndex, startIndex + this.itemsPerPage);

      return paginatedObj;
    },
  },
};
</script>
