export default {
  data() {
    return {
      messageTypes: {
        normal: 'normal',
        error: 'error',
      },
    };
  },
  methods: {
    setMessage(messageText, type = this.messageTypes.normal) {
      this.app.message.text = messageText;
      this.app.message.type = type;
      this.app.message.time = new Date();
    },
  },
};
