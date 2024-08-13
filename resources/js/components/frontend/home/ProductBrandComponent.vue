<template>
    <LoadingComponent :props="loading" />

    <section class="mb-3 sm:mb-10" v-if="brands.length > 1">
        <div class="container">
            <h2 class="capitalize text-2xl sm:text-4xl font-bold -mb-10 text-yellow-W">
                MARCAS POPULARES
            </h2>
            <Swiper dir="ltr" :speed="1000" :loop="true" :navigation="true" :modules="modules" class="navigate-swiper" :breakpoints="breakpoints">
                <SwiperSlide v-for="brand in brands" class="mobile:!w-[120px]">
                    <router-link :to="{name: 'frontend.product', query:{ brand: brand.id }}" class="w-full rounded-2xl shadow-xs group border border-gray-100">
                        <figure class="w-full h-[120px] flex items-center justify-center">
                            <img :src="brand.cover" alt="brand" loading="lazy" class="w-14">
                        </figure>
                        <span class="text-sm sm:text-lg font-medium capitalize text-center pb-3 block group-hover:text-primary">
                                {{ brand.name }}
                            </span>
                    </router-link>
                </SwiperSlide>
            </Swiper>
        </div>
    </section>
</template>

<script>
import statusEnum from "../../../enums/modules/statusEnum";
import LoadingComponent from "../components/LoadingComponent";
import {Swiper, SwiperSlide} from "swiper/vue";
import {Autoplay, Navigation, Pagination} from "swiper/modules";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default {
    name: "ProductBrandComponent",
    components: {
        Swiper, SwiperSlide,
        LoadingComponent
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            breakpoints: {
                0: {slidesPerView: 'auto', spaceBetween: 16},
                640: {slidesPerView: 4, spaceBetween: 24},
                768: {slidesPerView: 5, spaceBetween: 24},
                1024: {slidesPerView: 6, spaceBetween: 24}
            },
        }
    },
    setup() {
        return {
            modules: [Navigation, Pagination, Autoplay],
        }
    },
    computed: {
        brands: function () {
            return this.$store.getters["frontendProductBrand/lists"];
        },
    },
    mounted() {
        this.loading.isActive = true;
        this.$store.dispatch("frontendProductBrand/lists", {
            paginate: 0,
            order_column: "id",
            order_type: "asc",
            status: statusEnum.ACTIVE,
        }).then(res => {
            this.loading.isActive = false;
        }).catch((err) => {
            this.loading.isActive = false;
        });
    }
}
</script>
<style>
.text-yellow-W {
    color: #e8a623 !important;
    text-transform: uppercase;
    font-size: 1.5rem !important;
    font-weight: 900;
}

.banner-button {
    position: absolute;
    top: 4px;
    right: 5px;
    padding: 1rem;
    background-color: #ffffffd0;
    border: none;
    border-radius: 5px;
    font-size: 1.2rem;
    font-weight: bold;
    color: red;
    cursor: pointer;
    transition: background-color 0.3s;
    border-radius: 30px;
}

@media (min-width: 768px){
    .banner-button {
        top: 28px;
        right: 34px;
        padding: 0.5rem 1rem;
    }
}

.banner-button:hover {
    background-color: #ffffff;
}

@media (max-width: 768px){
    .banner-button {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
    }
}

.banner-image-cat {
    margin-top: 1rem;
    margin-bottom: 12px;
}

</style>
