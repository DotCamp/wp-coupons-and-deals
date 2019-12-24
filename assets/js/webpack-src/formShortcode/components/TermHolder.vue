<template>
  <hide-box :heading="heading">
    <div :key="forceUpdateKey">
      <term v-for="term in hierarchicalTerms" :term="term" :key="term.name" @change="pushTerms" :terms="checkedTerms" />
      <term-insert
        v-if="termInsert"
        :heading="heading"
        :terms="hierarchicalTerms"
        :raw="extras.terms"
        :taxname="taxname"
        @createNewTerm="insertNewTerm"
      />
    </div>
  </hide-box>
</template>
<script>
import Term from './Term';
import TermInsert from './TermInsert';
import HideBox from './HideBox';

export default {
  props: ['heading', 'terms', 'taxname', 'termsChecked', 'termInsert'],
  components: { HideBox, Term, TermInsert },
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
    this.checkedTerms = this.termsChecked;
  },
  methods: {
    insertNewTerm(termObj) {
      if (!this.store.newTerms) {
        this.store.newTerms = {};
      }

      if (!this.store.newTerms[this.taxname]) {
        this.store.newTerms[this.taxname] = [];
      }

      this.store.newTerms[this.taxname].push(termObj);
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
    hierarchicalTerms() {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.forceUpdateKey += 1;
      this.sortTerms();
      const filtered = this.terms.filter(t => {
        return t.parent === 0;
      });
      return { ...filtered };
    },
  },
};
</script>
