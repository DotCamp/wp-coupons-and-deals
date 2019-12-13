<template>
  <tr>
    <td>
      <form-label :helpmessage="helpmessage" :id="id">
        {{ label }}
      </form-label>
    </td>
    <td>
      <input :placeholder="extras.strings.enter_title" v-model="store['coupon-title']" :id="id" type="text" class="wpcd-fs-w-full-important"/>
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
