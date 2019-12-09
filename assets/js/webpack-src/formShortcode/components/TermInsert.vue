<template>
  <div class="text-2xl font-bold">
    <a @click="opened = !opened" class="cursor-pointer underline text-green-500"
      >{{ opened ? '-' : '+' }} Add New {{ heading }}</a>
    <div class="p-2" v-if="opened">
      <div>
        <input v-model.trim="newTermName" class="border-green-500 border rounded" />
      </div>
      <div class="my-2">
        <select v-model="selection">
          <option value="0" selected>Parent {{ heading }}</option>
          <term-option v-for="t in terms" :key="t.name" :term="t" padding="" />
          <!--          <option v-for="term in terms" :key="term.name" :value="term.name">{{ term.name }}</option>-->
        </select>
      </div>
      <a @click.prevent="insert" class="p-1 my-2 rounded border-2" :class="classBindings">{{ extras.strings.Add }}</a>
    </div>
  </div>
</template>
<script>
import TermOption from './TermOption';

export default {
  props: ['heading', 'terms', 'taxname', 'raw'],
  components: { TermOption },
  data() {
    return {
      newTermName: '',
      opened: false,
      selection: '0',
    };
  },
  methods: {
    insert() {
      if (this.checkAddConditions()) {
        this.$emit('createNewTerm', { name: this.newTermName, parent: parseInt(this.selection, 10) });
        this.opened = false;
      }
    },
    checkAddConditions() {
      const haveSameName = this.raw[this.taxname].filter(t => t.name === this.newTermName).length > 0;

      return this.newTermName !== '' && !haveSameName;
    },
  },
  computed: {
    classBindings() {
      return {
        'cursor-pointer': this.checkAddConditions(),
        'cursor-default': !this.checkAddConditions(),
        'text-gray-300': !this.checkAddConditions(),
        'border-green-500': this.checkAddConditions(),
      };
    },
  },
};
</script>
