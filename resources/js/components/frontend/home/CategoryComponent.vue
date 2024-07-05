<template>
    <LoadingComponent :props="loading" />
    <section v-if="categories.length > 0" class="sm:mb-10 hidden">
        <div class="container">
            <h2 class="text-2xl sm:text-4xl font-bold -mb-10">{{ $t('label.browse_by_categories') }}</h2>
            <Swiper dir="ltr" :speed="1000" :loop="true" :navigation="true" :modules="modules" class="navigate-swiper" :breakpoints="breakpoints">
                <SwiperSlide v-for="category in categories" class="mobile:!w-24">
                    <router-link :to="{name: 'frontend.product', query: { category: category.slug }}"
                                 class="w-full rounded-2xl shadow-xs group">
                        <img class="w-full block rounded-tl-2xl rounded-tr-2xl" :src="category.thumb" alt="category" loading="lazy">
                        <span class="text-sm sm:text-xl font-medium capitalize text-center py-2 px-3 overflow-hidden whitespace-nowrap text-ellipsis block rounded-bl-2xl rounded-br-2xl group-hover:text-primary">
                            {{ category.name }}
                        </span>
                    </router-link>
                </SwiperSlide>
            </Swiper>
        </div>
    </section>
    <section>
        <div class="container-mar">
            <div class="section-mar text-right">
                <h2 class="title">Sección</h2>
                <h2 class="title-m">Supermercado</h2>
                <a class="button" href="/#/supermercado">
                    <span>Visítanos</span>
                </a>
            </div>
            <div class="section-mar text-right">
                <h2 class="title">Sección</h2>
                <h2 class="title-m">Ferreteria</h2>
                <a class="button" href="/#/ferreteria">
                    <span>Visítanos</span>
                </a>
            </div>
            <div class="section-mar text-right">
                <h2 class="title">Sección</h2>
                <h2 class="title-m">Hogar</h2>
                <a class="button" href="/#/hogar">
                    <span>Visítanos</span>
                </a>
            </div>
            <div class="section-mar text-right">
                <h2 class="title">Sección</h2>
                <h2 class="title-m">Mascotas</h2>
                <a class="button" href="/#/mascotas">
                    <span>Visítanos</span>
                </a>
            </div>
        </div>
    </section>
        <!-- Sección de Categorías Principales -->
        <section v-if="categories.length > 0" class="sm:mb-10">
            <div class="container">
                <h2 class="text-2xl sm:text-4xl font-bold -mb-10 text-yellow">{{ $t('label.browse_by_categories') }}</h2>
                <Swiper dir="ltr" :speed="1000" :loop="true" :navigation="true" :modules="modules" class="navigate-swiper" :breakpoints="breakpoints">
                    <SwiperSlide v-for="category in categories" :key="category.id" class="mobile:!w-24">
                        <router-link :to="{ name: 'frontend.product', query: { category: category.slug }}" class="w-full rounded-2xl shadow-xs group">
                            <span class="text-sm sm:text-xl font-medium capitalize text-center py-2 px-3 overflow-hidden whitespace-nowrap text-ellipsis block rounded-bl-2xl rounded-br-2xl group-hover:text-primary">
                                {{ category.name }}
                            </span>
                        </router-link>
                    </SwiperSlide>
                </Swiper>
            </div>
        </section>

        <!-- Sección de Subcategorías y Productos -->
        <section v-if="selectedCategory">
            <div class="container">
                <!-- Nombre de la Categoría Principal -->
                <h2 class="text-2xl sm:text-4xl font-bold -mb-10 text-yellow">{{ selectedCategory.name }}</h2>

                <!-- Swiper para Subcategorías -->
                <Swiper dir="ltr" :speed="1000" :loop="true" :navigation="true" :modules="modules" class="navigate-swiper" :breakpoints="breakpoints">
                    <SwiperSlide v-for="subcategory in subcategories" :key="subcategory.id" class="mobile:!w-24">
                        <router-link :to="{ name: 'frontend.product', query: { category: subcategory.slug }}" class="w-full rounded-2xl shadow-xs group">
                            <span class="text-sm sm:text-xl font-medium capitalize text-center py-2 px-3 overflow-hidden whitespace-nowrap text-ellipsis block rounded-bl-2xl rounded-br-2xl group-hover:text-primary">
                                {{ subcategory.name }}
                            </span>
                        </router-link>
                    </SwiperSlide>
                </Swiper>

                <!-- Swiper para Productos -->
                <Swiper dir="ltr" :speed="1000" :loop="true" :navigation="true" :modules="modules" class="navigate-swiper" :breakpoints="breakpoints">
                    <SwiperSlide v-for="product in products" :key="product.id" class="mobile:!w-[120px]">
                        <router-link :to="{ name: 'frontend.product', query: { brand: product.id }}" class="w-full rounded-2xl shadow-xs group border border-gray-100">
                            <figure class="w-full h-[120px] flex items-center justify-center">
                                <img :src="product.cover" alt="product" loading="lazy" class="w-14">
                            </figure>
                            <span class="text-sm sm:text-lg font-medium capitalize text-center pb-3 block group-hover:text-primary">
                                {{ product.name }}
                            </span>
                        </router-link>
                    </SwiperSlide>
                </Swiper>
            </div>
        </section>
</template>

<script>
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import statusEnum from "../../../enums/modules/statusEnum";
import LoadingComponent from "../components/LoadingComponent";

export default {
    name: "CategoryComponent",
    components: {
        Swiper,
        SwiperSlide,
        LoadingComponent
    },
    setup() {
        return {
            modules: [Navigation, Pagination, Autoplay],
        }
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            settings: {
                itemsToShow: 6,
                wrapAround: false,
                snapAlign: "start"
            },
            breakpoints: {
                0: { slidesPerView: 'auto', spaceBetween: 16 },
                640: { slidesPerView: 4, spaceBetween: 24 },
                768: { slidesPerView: 5, spaceBetween: 24 },
                1024: { slidesPerView: 6, spaceBetween: 24 }
            },
        }
    },
    computed: {
        categories: function () {
            return this.$store.getters["frontendProductCategory/lists"];
        },
    },
    mounted() {
        this.loading.isActive = true;
        // Cargar las categorías principales
        this.$store.dispatch("frontendProductCategory/lists", {
            paginate: 0,
            order_column: "id",
            parent_id: null,
            status: statusEnum.ACTIVE,
        }).then(res => {
            this.loading.isActive = false;
        }).catch((err) => {
            this.loading.isActive = false;
        });
    },
}
</script>
<style>
.container-mar {
    display: flex;
    flex-wrap: wrap;
    max-width: 1500px;
    justify-content: space-between;
}

.section-mar {
    flex: 1 1 calc(20% - 20px);
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;
    background-color: #cf362f;
    margin-bottom: 20px;
    padding: 10px;
    min-height: 175px;
    transition: transform 0.3s;
    margin: 10px;
}

.section-mar:hover {
    transform: translateY(-5px) scale(1.03);
}

.title-m {
    margin: 0;
    font-size: 19px;
    color: #fff;
    text-transform: uppercase;
}
.title {
    margin: 0;
    font-size: 10px;
    color: #fff;
    text-transform: uppercase;
}
.button {
    text-decoration: none;
    color: #fff;
    background-color: #000;
    padding: 10px 20px;
    border-radius: 23px;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #444;
}

@media (max-width: 767px) {
    .container-mar {
    display: block;
    flex-direction: column;
    align-items: center;
    max-width: 1500px;
    }

    .section-mar {
        flex-basis: auto;
    }

    .text-right {
        text-align: left;
    }
}
.text-yellow {
    color: #e8a623;
    text-transform: uppercase;
    font-size: 1.5rem !important;
}

</style>

