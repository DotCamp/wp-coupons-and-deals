<template>
  <div>
    <input :checked="checked" ref="checkbox" type="checkbox" :value="term.term_id" @change="onChange" />
    <label
      class="wpcd-fs-p-1 wpcd-fs-rounded wpcd-form-shortcode-generic-transition"
      :style="{
        backgroundColor: isChecked() ? 'green' : '',
        color: isChecked() ? 'white' : '',
      }"
      >{{ term.name }}</label
    >
    <div v-if="recursive && term.child && term.child.length > 0" style="margin-left: 2rem">
      <term
        :recursive="true"
        v-for="t in term.child"
        :key="t.term_id"
        :term="t"
        @change="$listeners.change"
        :terms="terms"
      />
    </div>
  </div>
</template>
<script>
export default {
  inheritAttrs: false,
  props: ['term', 'terms', 'recursive'],
  name: 'term',
  data() {
    return {
      checked: this.terms.includes(this.term.term_id),
    };
  },
  methods: {
    isChecked() {
      return this.checked;
    },
    onChange(e) {
      this.$emit('change', e.target.value);
      this.checked = !this.checked;
    },
  },
};
</script>
