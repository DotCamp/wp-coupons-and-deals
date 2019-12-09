<template>
  <fragment>
    <option v-if="term.term_id" :value="term.term_id">{{ padding + term.name }}</option>
    <term-option v-for="t in term.child" :key="t.name" :term="t" :padding="padding + '_'" />
  </fragment>
</template>
<script>
export default {
  name: 'term-option',
  props: ['term', 'padding'],
};
</script>
