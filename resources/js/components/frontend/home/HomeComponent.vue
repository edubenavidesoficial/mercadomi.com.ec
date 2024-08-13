<template>
    <div class="padding-lg">
        <SliderComponent />

        <CategoryComponent />

        <PromotionComponent />

        <ProductSectionComponent />

        <MostPopularComponent />

        <FlashSaleComponent />

        <ProductBrandComponent />

        <BenefitComponent />
    </div>
</template>

<script>

import SliderComponent from "./SliderComponent.vue";
import CategoryComponent from "./CategoryComponent.vue";
import PromotionComponent from "./PromotionComponent.vue";
import BenefitComponent from "./BenefitComponent.vue";
import ProductSectionComponent from "./ProductSectionComponent.vue";
import FlashSaleComponent from "./FlashSaleComponent.vue";
import ProductBrandComponent from "./ProductBrandComponent.vue";
import MostPopularComponent from "./MostPopularComponent.vue";

export default {
    name: "HomeComponent",
    components: {
        MostPopularComponent,
        FlashSaleComponent,
        BenefitComponent,
        SliderComponent,
        CategoryComponent,
        PromotionComponent,
        ProductSectionComponent,
        ProductBrandComponent
    }
};
</script>
<style>
/* styles.css or similar file */
.padding-lg {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
}

@media (min-width: 768px) {
    .padding-lg {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
}

@media (min-width: 1024px) {
    .padding-lg {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }
}

</style>