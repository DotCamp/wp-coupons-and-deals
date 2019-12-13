<template>
  <div>
    <input :checked="checked" ref="checkbox" type="checkbox" :value="term.name" @change="onChange" />
    <label
      class="wpcd-fs-p-1 wpcd-fs-rounded wpcd-form-shortcode-generic-transition"
      :style="{
        backgroundColor: isChecked() ? 'green' : '',
        color: isChecked() ? 'white' : '',
      }"
      >{{ term.name }}</label
    >
    <div v-if="term.child && term.child.length > 0" style="margin-left: 2rem">
      <term v-for="t in term.child" :key="t.name" :term="t" @change="$listeners.change" />
    </div>
  </div>
</template>
<script>
export default {
  inheritAttrs: false,
  props: ['term'],
  name: 'term',
  data() {
    return {
      checked: false,
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
