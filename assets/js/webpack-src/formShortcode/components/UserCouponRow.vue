<template>
  <tr
    class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade"
    :class="isHighlighted"
    @mouseover="mouseOver(true)"
    @mouseout="mouseOver(false)"
  >
    <td>
      <div class="wpcd-fs-bold">
        <span @click="$emit('edit', ID)" class="wpcd-fs-text-blue-500 wpcd-fs-pointer">{{ post_title }}</span>
        <span>{{ post_status === 'publish' ? '' : ('| ' + post_status) | cap }} </span>
      </div>
      <div :style="{ visibility: hover ? 'visible' : 'hidden' }" class="wpcd-fs-text-sm">
        <a class="wpcd-fs-pointer wpcd-fs-text-blue-500" @click="$emit('edit', ID)">Edit</a>
        <span v-if="extras.options.thrash_enable === 'on'">
          |
          <a class="wpcd-fs-pointer wpcd-fs-text-red-500" @click="$emit('thrash', ID)">Thrash</a>
        </span>
      </div>
    </td>
    <td>
      {{ coupon_type }}
    </td>
    <td :title="renderTerms('category')">
      {{ renderTerms('category') | truncate(10) }}
    </td>
    <td :title="renderTerms('vendor')">
      {{ renderTerms('vendor') | truncate(10) }}
    </td>
    <td>{{ localizedExpire | cap }}</td>
    <td>
      <shortcode-copy :id="shortcode.replace(':id', ID)" />
    </td>
  </tr>
</template>
<script>
import ShortcodeCopy from './ShortcodeCopy';
import { toMilliSeconds } from '../functions/EzTime';
import HighlightMixin from './mixins/HighlightMixin';

export default {
  mixins: [HighlightMixin],
  props: ['post_title', 'post_status', 'coupon_type', 'ID', 'terms', 'shortcode', 'expire'],
  components: { ShortcodeCopy },
  data() {
    return {
      hover: false,
    };
  },
  computed: {
    localizedExpire() {
      if (this.expire !== null) {
        const expireDate = new Date(toMilliSeconds(this.expire));
        const expired = expireDate < Date.now();

        return expired ? this.extras.strings.expired : new Intl.DateTimeFormat().format(expireDate);
      }
      return this.extras.strings.no_expire;
    },
    isHighlighted() {
      const isIt = Number.parseInt(this.ID, 10) === Number.parseInt(this.highlightId, 10);
      return isIt ? [this.highlightClass] : '';
    },
  },
  methods: {
    mouseOver(status) {
      this.hover = status;
      // reset highlight styles on hover
      this.highlightClass = '';
    },
    renderTerms(name) {
      if (this.terms[name].length > 0) {
        const tempArray = [];
        this.terms[name].map(t => {
          tempArray.push(t.name);
        });

        return tempArray.join(', ');
      }
      return '---';
    },
  },
};
</script>
