export default {
  methods: {
    scrollTo(markerId) {
      const parsedId = markerId[0] === '#' ? markerId : `#${markerId}`;
      const marker = document.querySelector(parsedId);
      if (marker) {
        window.scrollTo({
          top: marker.offsetTop,
          left: 0,
        });
      } else {
        throw new Error('scroll marker not found');
      }
    },
  },
};
