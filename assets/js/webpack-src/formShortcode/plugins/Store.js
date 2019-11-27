/**
 * plugin install method
 * @param Vue Vue object
 * @param options options array to be used
 */
function install(Vue, options) {
  // adding singleton store object to share some data especially between form and coupon preview for live updates
  Vue.mixin({
    data() {
      return {
        store: options.store,
      };
    },
  });
}

/**
 * @module store plugin
 */
export default {
  install,
};
