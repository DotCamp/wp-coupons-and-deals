<script>
/* eslint-disable no-param-reassign */

import BaseTemplate from './BaseTemplate';
import EzTime from '../../functions/EzTime';

export default {
  mixins: [BaseTemplate],
  mounted() {
    // const expiresOn = document.querySelector('.expires-on');
    // expiresOn.style = '';
    // expiresOn.classList.add('hidden');
    this.prepareCountdown();
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
        'coupon-title': '.admin_wpcd_seven_new_title',
        'coupon-code-text': [
          {
            element: '.coupon-code-button',
            format: (value, el) => {
              if (value !== undefined) el.dataset.titleAb = value;
            },
          },
        ],
        'deal-button-text': [
          {
            element: '.deal-code-button',
            format: (value, el) => {
              if (value !== undefined) el.dataset.titleAb = value;
            },
          },
        ],
        'discount-text': '.admin_wpcd_seven_percentOff p',
        wpcd_description: '.wpcd-coupon-description',
        'hide-coupon': [
          {
            element: '.wpcd-coupon-hidden',
            format: (value, el) => {
              el.style.display = value === 'Yes' ? 'block' : 'none';
            },
          },
        ],
        'template-seven-theme': [
          {
            element: '.admin_wpcd_seven_percentOff',
            format: (value, el) => {
              el.style.backgroundColor = value;
              el.style.borderColor = value;
            },
          },
          {
            element: '.admin_wpcd_seven_couponBox',
            format: (value, el) => {
              el.style.borderColor = value;
            },
          },
          {
            element: '.wpcd-coupon-code .coupon-code-button',
            format: (value, el) => {
              el.style.borderColor = value;
              el.style.color = value;
              el.style.backgroundColor = value;
            },
          },
          {
            element: '.wpcd-deal-code .deal-code-button',
            format: (value, el) => {
              el.style.borderColor = value;
              el.style.color = value;
              el.style.backgroundColor = value;
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
              this.prepareCountdown();
            },
          },
        ],
        'expire-time': [
          {
            element: '.expires-on',
            format: () => {
              this.prepareCountdown();
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.never-expire': () => this.store['never-expire-check'] === 'on' || this.store['expire-date'] === undefined,
        '.expires-on': () => this.store['never-expire-check'] === 0 || this.store['never-expire-check'] === undefined,
      },
    };
  },
  methods: {
    prepareCountdown() {
      this.countdownMS =
        this.toMilliSeconds(this.store['expire-date']) + this.decodeTime(this.store['expire-time']) - Date.now();

      this.countDown();
    },
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
