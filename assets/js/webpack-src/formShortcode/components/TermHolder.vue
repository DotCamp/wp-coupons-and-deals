<template>
  <div class="bg-white mt-4 mb-4 shadow">
    <div
      @click="showTerms = !showTerms"
      class="wpcd-form-shortcode-generic-transition hover:bg-gray-200 cursor-pointer text-2xl font-bold border border-l-0 border-r-0 border-b-2 p-2"
    >
      {{ heading }}
      <div class="wpcd-form-shortcode-toggle-button h-4 float-right" :aria-expanded="JSON.stringify(showTerms)">
        <span class="wpcd-form-shortcode-toggle-indicator"></span>
      </div>
    </div>
    <div v-show="showTerms" class="p-2 form-shortcode-row" :key="forceUpdateKey">
      <term v-for="term in hierarchicalTerms" :term="term" :key="term.name" @change="pushTerms" />
      <term-insert
        :heading="heading"
        :terms="hierarchicalTerms"
        :raw="extras.terms"
        :taxname="taxname"
        @createNewTerm="insertNewTerm"
      />
    </div>
  </div>
</template>
<script>
import Term from './Term';
import TermInsert from './TermInsert';

export default {
  props: ['heading', 'terms', 'taxname'],
  components: { Term, TermInsert },
  data() {
    return {
      checkedTerms: [],
      newTermName: '',
      forceUpdateKey: 0,
      showTerms: false,
    };
  },
  watch: {
    checkedTerms() {
      this.$emit('termsChanged', this.taxname, this.checkedTerms);
    },
  },
  created() {
    this.sortTerms();
  },
  methods: {
    insertNewTerm(termObj) {
      if (!this.app.newTerms) {
        this.app.newTerms = {};
      }

      if (!this.app.newTerms[this.taxname]) {
        this.app.newTerms[this.taxname] = [];
      }

      this.app.newTerms[this.taxname].push(termObj);
      this.terms.push(termObj);
      this.sortTerms();
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
    sortTerms() {
      this.terms.map(t => {
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
    hierarchicalTerms() {
      this.forceUpdateKey++;
      const filtered = this.terms.filter(t => {
        return t.parent === 0;
      });
      return { ...filtered };
    },
  },
};
</script>
