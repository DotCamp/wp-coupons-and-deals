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
        storeBase: { ...options.store },
        extras: { ...options.extras },
        app: options.app,
      };
    },
    methods: {
      startFetching() {
        this.app.submit.fetching = true;
      },
      stopFetching() {
        this.app.submit.fetching = false;
      },
      resetStore() {
        Object.keys(this.store).map(k => {
          if (Object.prototype.hasOwnProperty.call(this.store, k)) {
            if (this.storeBase[k]) {
              this.store[k] = this.storeBase[k];
            } else {
              delete this.store[k];
            }
          }
        });
      },
    },
    computed: {
      isFetching() {
        return this.app.submit.fetching;
      },
    },
  });
}

/**
 * @module store plugin
 */
export default {
  install,
};
