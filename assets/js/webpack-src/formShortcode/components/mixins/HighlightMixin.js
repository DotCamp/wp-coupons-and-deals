export default {
  data() {
    return {
      highlightClass: 'wpcd-fs-tr-highlight',
    };
  },
  methods: {
    resetHighlight() {
      this.app.latest.id = '';
    },
  },
  computed: {
    highlightId: {
      get() {
        return this.app.latest.id;
      },
      set(id) {
        this.app.latest.id = id;
      },
    },
  },
};
