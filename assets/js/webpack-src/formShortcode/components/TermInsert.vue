<template>
  <div class="wpcd-fs-my-2">
    <a @click="opened = !opened" class="wpcd-fs-pointer wpcd-fs-bold">{{ opened ? '-' : '+' }} Add New {{ heading }}</a>
    <div class="wpcd-fs-p-2 wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade" v-if="opened">
      <div>
        <input v-model.trim="newTermName" class="wpcd-fs-rounded wpcd-fs-w-full-important" />
      </div>
      <div class="wpcd-fs-my-2">
        <select v-model="selection">
          <option value="0" selected>Parent {{ heading }}</option>
          <term-option v-for="t in terms" :key="t.name" :term="t" padding="" />
          <!--          <option v-for="term in terms" :key="term.name" :value="term.name">{{ term.name }}</option>-->
        </select>
      </div>
      <input
        :disabled="!checkAddConditions"
        class="button"
        type="button"
        @click.prevent="insert"
        :value="extras.strings.Add"
      />
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
      if (this.checkAddConditions) {
        this.$emit('createNewTerm', { name: this.newTermName, parent: parseInt(this.selection, 10), child: [] });
        this.opened = false;
      }
    },
  },
  computed: {
    checkAddConditions() {
      // const haveSameName = this.raw[this.taxname].filter(t => t.name === this.newTermName).length > 0;

      const haveSameName = this.raw[this.taxname]
        .filter(t => t.parent === parseInt(this.selection, 10))
        .some(c => c.name === this.newTermName);

      return this.newTermName !== '' && !haveSameName;
    },
  },
};
</script>
