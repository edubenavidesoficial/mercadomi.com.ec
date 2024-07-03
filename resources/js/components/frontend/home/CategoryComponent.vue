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
</template>

<script>

import {Navigation, Pagination, Autoplay} from 'swiper/modules';
import {Swiper, SwiperSlide} from 'swiper/vue';
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
                0: {slidesPerView: 'auto', spaceBetween: 16},
                640: {slidesPerView: 4, spaceBetween: 24},
                768: {slidesPerView: 5, spaceBetween: 24},
                1024: {slidesPerView: 6, spaceBetween: 24}
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
        this.$store.dispatch("frontendProductCategory/lists", {
            paginate: 0,
            order_column: "id",
            order_type: "asc",
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
    display: block; /* O cualquier estilo que desees aplicar */
        flex-direction: column;
        justify-content: flex-start;
}

.section-mar {
    display: flex;
    flex-direction: column;
    align-items: flex-end; /* Cambia el alineamiento de los elementos hijos a la derecha */
    justify-content: center;
    background-color: #cf362f;
    margin-bottom: 20px;
    padding: 10px;
    min-height: 175px;
    transition: transform 0.3s;
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
        margin: 0;
    }

    .text-right {
        text-align: left;
    }
}
</style>

