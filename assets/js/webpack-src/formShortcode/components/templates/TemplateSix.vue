<script>
/* eslint-disable no-param-reassign */

import BaseTemplate from './BaseTemplate';
import EzTime from '../../functions/EzTime';

export default {
  mixins: [BaseTemplate],
  mounted() {
    const expiresOn = document.querySelector('.expires-on');
    expiresOn.style = '';
    expiresOn.classList.add('hidden');
  },
  watch: {
    countdownMS(n) {
      const el = document.querySelector('.expires-on');
      const expired = n <= 0;
      if (expired) {
        el.classList.add('wpcd-countdown-expired');
        el.classList.remove('wpcd-coupon-two-countdown');
      } else {
        el.classList.add('wpcd-coupon-two-countdown');
        el.classList.remove('wpcd-countdown-expired');
      }

      const offerExpired = this.extras.strings.offer_expired_text;
      const expirePart = this.extras.strings.expire_text;
      const timeTranslations = {
        second: [this.extras.strings.second, this.extras.strings.seconds],
        minute: [this.extras.strings.minute, this.extras.strings.minutes],
        hour: [this.extras.strings.hour, this.extras.strings.hours],
        day: [this.extras.strings.day, this.extras.strings.days],
        week: [this.extras.strings.week, this.extras.strings.weeks],
        month: [this.extras.strings.month, this.extras.strings.months],
        year: [this.extras.strings.year, this.extras.strings.years],
      };
      const timeString = new EzTime(n, timeTranslations);
      const humanReadableTimeString = `${timeString}`;

      el.textContent = `${expirePart}${expired ? offerExpired : ''}${expired ? '' : humanReadableTimeString}`;
    },
  },
  data() {
    return {
      countdownMS: 0,
      values: {
        'coupon-title': '.wpcd-coupon-six-title',
        'coupon-code-text': '.coupon-code-button',
        'discount-text': '.wpcd-coupon-six-discount-text',
        wpcd_description: '.wpcd-coupon-description',
        'deal-button-text': '.deal-code-button',
        'template-six-theme': [
          {
            element: '.exp',
            format: (value, el) => {
              el.style.borderColor = value;
            },
          },
          {
            element: '.wpcd-ribbon',
            format: (value, el) => {
              el.style.backgroundColor = value;
            },
          },
          {
            element: '.wpcd-ribbon-before',
            format: (value, el) => {
              el.style.borderLeftColor = value;
            },
          },
          {
            element: '.wpcd-ribbon-after',
            format: (value, el) => {
              el.style.borderRightColor = value;
            },
          },
          {
            element: '.wpcd-coupon-preview',
            format: (value, el) => {
              el.style.borderColor = value;
            },
          },
          {
            element: '.wpcd-template-six-btn',
            format: (value, el) => {
              el.style.borderColor = value;
            },
          },
          {
            element: '.coupon-code-button',
            format: (value, el) => {
              el.style.color = value;
            },
          },
          {
            element: '.deal-code-button',
            format: (value, el) => {
              el.style.color = value;
              el.style.borderColor = value;
            },
          },
          {
            element: '.wpcd-btn-wrap .coupon-code-wpcd',
            format: (value, el) => {
              el.style.borderColor = value;
            },
          },
          {
            element: '.square_wpcd',
            format: (value, el) => {
              el.style.backgroundColor = value;
            },
          },
          {
            element: '.rectangle_wpcd',
            format: (value, el) => {
              el.style.borderLeftColor = value;
            },
          },
        ],
        'expire-date': [
          {
            element: '.expires-on',
            format: () => {
              this.countdownMS =
                new Date(`${this.store['expire-date']} ${this.store['expire-time'] || ''}`) - Date.now();

              this.countDown();
            },
          },
        ],
        'expire-time': [
          {
            element: '.expires-on',
            format: () => {
              this.countdownMS =
                new Date(`${this.store['expire-date']} ${this.store['expire-time'] || ''}`) - Date.now();

              this.countDown();
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.exp': () => this.store['show-expiration'] === 'Show',
        '.never-expire': () => this.store['never-expire-check'] === 'on' || this.store['expire-date'] === undefined,
        '.expires-on': () =>
          this.store['never-expire-check'] === 0 || this.store['never-expire-check'] === undefined,
      },
    };
  },
  methods: {
    countDown() {
      const vm = this;
      clearInterval(this.intervalid);

      this.intervalid = setInterval(function handler() {
        vm.countdownMS -= 1000;
      }, 1000);
    },
  },
};
</script>
