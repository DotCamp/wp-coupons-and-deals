<template>
  <tr>
    <td>
      <form-label :helpmessage="helpmessage" :id="id">
        {{ label }}
      </form-label>
    </td>
    <td>
      <input v-model="store['coupon-title']" :id="id" />
    </td>
  </tr>
</template>
<script>
import FormLabel from './FormLabel';

export default {
  components: { FormLabel },
  props: ['helpmessage', 'id', 'label'],
};
</script>
