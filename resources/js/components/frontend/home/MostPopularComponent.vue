<template>
    <LoadingComponent :props="loading"/>
    <section v-if="products.length > 0" class="mb-7 sm:mb-12">
        <br>
        <div class="container">
            <div class="flex items-center justify-between gap-4 mb-5 sm:mb-7">
                <h2 class="text-2xl sm:text-4xl font-bold capitalize text-yellow">
                    ALIMENTOS
                </h2>
                <router-link :to="{ path: '/product', query: { category: 'ALIMENTOS' } }" class="py-2 px-4 text-sm sm:py-3 sm:px-6 rounded-3xl capitalize sm:text-base font-semibold whitespace-nowrap bg-primary-slate text-primary transition-all duration-300 hover:bg-primary hover:text-white">
                    Mostrar más
                </router-link>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <ProductListComponent v-if="products.length > 0" :products="products"/>
            </div>
            <div>
                <div class="block w-full h-full relative">
                    <img
                        class="banner-image-cat"
                        src="https://mercadomi.com.ec/storage/31/conversions/freshthursday.png"
                        srcset="
                            https://mercadomi.com.ec/storage/31/conversions/freshthursday-small.png 600w,
                            https://mercadomi.com.ec/storage/31/conversions/freshthursday-medium.png 1200w,
                            https://mercadomi.com.ec/storage/31/conversions/freshthursday-large.png 1800w"
                        sizes="(max-width: 600px) 100vw, (max-width: 1200px) 50vw, 33vw"
                        alt="banner"
                        loading="lazy">
                    <router-link :to="{ path: '/product', query: { category: 'frutas-y-verduras' } }" class="banner-button">
                        Mostrar más
                    </router-link>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="flex items-center justify-between gap-4 mb-5 sm:mb-7">
                <h2 class="text-2xl sm:text-4xl font-bold capitalize text-yellow">
                    LACTEOS
                </h2>
                <router-link :to="{ path: '/product', query: { category: 'lacteos' } }" class="py-2 px-4 text-sm sm:py-3 sm:px-6 rounded-3xl capitalize sm:text-base font-semibold whitespace-nowrap bg-primary-slate text-primary transition-all duration-300 hover:bg-primary hover:text-white">
                    Mostrar más
                </router-link>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <ProductListComponent v-if="products.length > 0" :products="products"/>
            </div>
            <div>
                <div class="block w-full h-full relative">
                    <img
                        class="banner-image-cat"
                        src="https://mercadomi.com.ec/storage/31/conversions/partiesjulianas.jpeg"
                        srcset="
                            https://mercadomi.com.ec/storage/31/conversions/partiesjulianas-small.jpeg 600w,
                            https://mercadomi.com.ec/storage/31/conversions/partiesjulianas-medium.jpeg 1200w,
                            https://mercadomi.com.ec/storage/31/conversions/partiesjulianas-large.jpeg 1800w"
                        sizes="(max-width: 600px) 100vw, (max-width: 1200px) 50vw, 33vw"
                        alt="banner"
                        loading="lazy">
                    <a href="/#/supermercado" class="banner-button">Mostrar más</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ProductListComponent from "../components/ProductListComponent.vue";
import LoadingComponent from "../components/LoadingComponent.vue";

export default {
    name: "MostPopularComponent",
    components: {
        ProductListComponent,
        LoadingComponent
    },
    data() {
        return {
            loading: {
                isActive: false,
            }
        }
    },
    computed: {
        products: function () {
            return this.$store.getters["frontendProduct/popularProducts"].slice(0,4);
        },
    },
    mounted() {
        this.loading.isActive = true;
        this.$store.dispatch("frontendProduct/popularProducts", {
            paginate: 0,
            rand: 8
        }).then(res => {
            this.loading.isActive = false;
        }).catch((err) => {
            this.loading.isActive = false;
        });
    },
}
</script>
<style>
.text-yellow {
    color: #e01616;
    text-transform: uppercase;
    font-size: 1.5rem;
}

.banner-button {
    position: absolute;
    padding: 1rem;
    background-color: rgba(255, 255, 255, 0.82);
    border: none;
    border-radius: 30px;
    font-size: 1.2rem;
    font-weight: bold;
    color: red;
    cursor: pointer;
    transition: background-color 0.3s;
}

.banner-button:hover {
    background-color: #ffffff;
}

@media (min-width: 768px) {
    .banner-button {
        top: 28px;
        right: 34px;
        padding: 0.5rem 1rem;
    }
}

@media (max-width: 768px) {
    .banner-button {
        top: 4px;
        right: 5px;
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
    }
}
</style>
