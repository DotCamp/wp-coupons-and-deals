import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import Edit from "./edit";

import "./style.scss";

registerBlockType(metadata.name, {
  ...metadata,
  edit: Edit,
  save: () => null,
  icon: (
    <svg
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <rect width="24" height="24" fill="white" />
      <path
        fillRule="evenodd"
        clipRule="evenodd"
        d="M5.47272 4.62474C4.97028 4.39547 4.3771 4.61692 4.14783 5.11936L3.28967 6.99999H10.678L5.47272 4.62474ZM20.7104 17H13.322L18.5273 19.3753C19.0298 19.6045 19.6229 19.3831 19.8522 18.8806L20.7104 17Z"
        fill="#329d40"
      />
      <path
        fillRule="evenodd"
        clipRule="evenodd"
        d="M2 9C2 8.44771 2.44772 8 3 8H8.5V9C8.5 9.27614 8.72386 9.5 9 9.5C9.27614 9.5 9.5 9.27614 9.5 9V8H21C21.5523 8 22 8.44771 22 9V10C20.8954 10 20 10.8954 20 12C20 13.1046 20.8954 14 22 14V15C22 15.5523 21.5523 16 21 16H9.5V15C9.5 14.7239 9.27614 14.5 9 14.5C8.72386 14.5 8.5 14.7239 8.5 15V16H3C2.44772 16 2 15.5523 2 15V14C3.10457 14 4 13.1046 4 12C4 10.8954 3.10457 10 2 10V9ZM9 10.5C9.27614 10.5 9.5 10.7239 9.5 11V13C9.5 13.2761 9.27614 13.5 9 13.5C8.72386 13.5 8.5 13.2761 8.5 13V11C8.5 10.7239 8.72386 10.5 9 10.5ZM17.3611 10.3458C17.5521 10.1464 17.5453 9.82985 17.3458 9.63886C17.1464 9.44788 16.8298 9.45475 16.6389 9.6542L12.5056 13.9708C12.3146 14.1702 12.3214 14.4867 12.5209 14.6777C12.7203 14.8687 13.0368 14.8618 13.2278 14.6624L17.3611 10.3458ZM15 10C15 10.5523 14.5523 11 14 11C13.4477 11 13 10.5523 13 10C13 9.44771 13.4477 9 14 9C14.5523 9 15 9.44771 15 10ZM16 15C16.5523 15 17 14.5523 17 14C17 13.4477 16.5523 13 16 13C15.4477 13 15 13.4477 15 14C15 14.5523 15.4477 15 16 15Z"
        fill="#329d40"
      />
    </svg>
  ),
  example: {
    viewportWidth: 900,
    attributes: {
      template: "default",
      discount: "100%",
      title: "Sample Coupon Code 2023",
      description:
        "This is a little description of the coupon code or deal. Just to let users know some additional details.",
      code: "SAMPLECODE",
      expiredDateText: "Expired",
      couponDealLabel: "Coupon",
      navigationLink: "",
      expirationDate: "10/30/2024",
      hideCoupon: false,
      couponCodeButtonText: "Show Code",
    },
  },
});
