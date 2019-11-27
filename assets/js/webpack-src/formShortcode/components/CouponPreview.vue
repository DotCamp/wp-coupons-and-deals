<template>
  <div
    class="italic flex items-center justify-center text-gray-500 font-mono w-full bg-gray-200 mb-16 shadow border-4 border-dashed border-gray-400 h-40 text-md"
  >
    <div>
      <div>Coupon Code: {{ store['coupon-code-text'] }}</div>
      <div>Show expiration date: {{ store['show-expiration'] }}</div>
      <div>Hide coupon: {{ store['hide-coupon'] }}</div>
    </div>
  </div>
</template>
