<template>
    <div class="text-gray-700">
        <div class="italic flex items-center justify-center text-gray-500 font-mono w-full bg-gray-200 mb-16 shadow border-4 border-dashed border-gray-400 h-40 text-md">
            coupon live preview
        </div>
        <div class="flex items-center flex-col bg-gray-100 border-t-4 border-l-4 shadow-lg rounded p-4">
            <div class="text-4xl font-bold bg-gray-200 p-2 rounded shadow">Coupon Submit Form</div>
            <div class="flex items-center flex-col m-4">
                <div class="m-2 text-sm p-2 bg-gray-200 border border-gray" v-if="showSampleField">{{fields[0]}}</div>
                <button @click="showSampleField=!showSampleField" class="text-sm p-2 rounded-full text-white">
                    {{showSampleField?'hide':'show'}} sample field data
                </button>
            </div>
            <form>
                <table class="border-collapse border-2 border-dashed">
                    <coupon-type v-model="currentType" :typedata="typedata"></coupon-type>
                    <tr is="CouponTypeForm" :fieldsdata="parsedFields"></tr>
                </table>
            </form>
        </div>
    </div>
</template>
<script>
    import CouponType from "./CouponType";
    import CouponTypeForm from "./CouponTypeForm";

    export default {
        props: ['fields'],
        components: {CouponType, CouponTypeForm},
        data() {
            return {
                showSampleField: false,
                typedata: this.fields.filter(f => f.id === 'coupon-type')[0],
                currentType: 'Coupon',
                currentTemplate: 'Default',
            };
        },
        computed: {
            parsedFields() {

                function filterFields(main, filters) {
                    return main.filter(m => {
                        return filters.filter(f => {
                            if (m.id.match(f) !== null) {
                                return m;
                            }
                        })[0];
                    })
                }

                const imageFilters = [/^link$/, /coupon-image.+/];
                const imageFields = filterFields(this.fields, imageFilters);

                const couponFilters = ['link', 'coupon-code-text', 'discount-text', 'wpcd-description', 'show-expiration', 'expire-date', 'hide-coupon'];

                const couponFields = filterFields(this.fields, couponFilters);

                const finalFields = {
                    Image: imageFields,
                    Coupon: couponFields,
                    Deal: couponFields
                };

                return finalFields[this.currentType];
            }
        }
    }
</script>