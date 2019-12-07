<template>
  <div class="bg-white mt-4 mb-4 shadow">
    <div class="text-2xl font-bold border border-l-0 border-r-0 border-b-2 p-2">{{ heading }}</div>
    <div class="p-2">
      <!--      <div v-for="term in terms" :key="term.name" :style="{ paddingLeft: term.parent !== 0 ? '2rem' : '' }">-->
      <!--        <input type="checkbox" :value="term.name" v-model="checkedTerms" />-->
      <!--        <label-->
      <!--          class="px-1 rounded"-->
      <!--          :style="{ backgroundColor: isChecked(term.name) ? 'green' : '', color: isChecked(term.name) ? 'white' : '' }"-->
      <!--          >{{ term.name }}</label-->
      <!--        >-->
      <!--      </div>-->
      <term v-for="term in hierarchicalTerms" :term="term" :key="term.name" @change="pushTerms" />
    </div>
    <div class="text-2xl font-bold">
      <a @click="onTermInsert = !onTermInsert" class="cursor-pointer underline text-green-500"
        >+ Add New {{ heading }}</a
      >
      <div class="p-2" v-if="onTermInsert">
        <div>
          <input v-model="newTermName" class="border-green-500 border rounded" />
        </div>
        <div class="my-2">
          <select>
            <option selected disabled>Parent {{ heading }}</option>
            <option v-for="term in terms" :key="term.name" :value="term.name">{{ term.name }}</option>
          </select>
        </div>
        <a class="p-1 my-2 border-green-500 rounded border-2">{{ extras.strings.Add }}</a>
      </div>
    </div>
  </div>
</template>
<script>
import Term from './Term';

export default {
  props: ['heading', 'terms', 'taxname'],
  components: { Term },
  data() {
    return {
      checkedTerms: [],
      onTermInsert: false,
      newTermName: '',
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
      this.terms.map(function recurs(f, i) {
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
      return this.terms.filter(t => {
        return t.parent === 0;
      });
    },
  },
};
</script>
