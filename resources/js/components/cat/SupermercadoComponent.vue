<template>
    <div>
        <a href="#" class="block w-full h-full relative">
            <img class="banner-image-cat" src="https://mercadomi.com.ec/storage/31/conversions/supermercado.png" alt="banner" loading="lazy">
            <div class="banner-text">Supermercado</div>
        </a>
    </div>
    <section v-if="categories.length > 0" class="sm:mb-10 hidden">
        <div class="container">
            <h2 class="text-2xl sm:text-4xl font-bold -mb-10">{{ $t('label.browse_by_categories') }}</h2>
            <Swiper dir="ltr" :speed="1000" :loop="true" :navigation="true" :modules="modules" class="navigate-swiper" :breakpoints="breakpoints">
                <SwiperSlide v-for="category in categories" :key="category.slug" class="mobile:!w-24">
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
        <div class="container-cat">
            <div v-for="category in staticCategories" :key="category.name" class="section-cat text-right">
                <h2 class="title">{{ category.title }}</h2>
                <h2 class="title-m">{{ category.name }}</h2>
                <a class="button" :href="category.link">
                    <span>{{ category.buttonText }}</span>
                </a>
            </div>
        </div>
    </section>
</template>

<script>
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import statusEnum from "../../enums/modules/statusEnum";
import LoadingComponent from "../frontend/components/LoadingComponent";

export default {
    name: "SupermercadoComponent",
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
            staticCategories: [
                { title: 'SECCIÓN', name: 'ALIMENTOS', link: '/#/product?category=alimentos', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'FRUTAS Y VERDURAS', link: '/#/product?category=frutas-y-verduras', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'LÁCTEOS', link: '/#/product?category=lacteos', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'BEBIDAS', link: '/#/product?category=bebidas', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'CONGELADOS', link: '/#/product?category=congelados', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'CARNES', link: '/#/product?category=carnes', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'PANIFICADOS', link: '/#/product?category=panificados', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'CONFITERIA', link: '/#/product?category=confiteria', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'SNACKS', link: '/#/product?category=snacks', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'VIDA SANA', link: '/#/product?category=vida-sana', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'BEBES', link: '/#/product?category=bebes', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'HIGIENE', link: '/#/product?category=higiene', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'COSMETICA', link: '/#/product?category=cosmetica', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'FARMACIA', link: '/#/product?category=farmacia', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'LIMPIEZA', link: '/#/product?category=limpieza', buttonText: 'VISÍTANOS' },
                { title: 'SECCIÓN', name: 'HOGAR', link: '/#/product?category=hogar', buttonText: 'VISÍTANOS' },
            ]
        }
    },
    computed: {
        categories() {
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
        }).catch(() => {
            this.loading.isActive = false;
        });
    },
}
</script>

<style>
.banner-image-cat {
    height: 60%;
    object-fit: cover;
    width: 100%;
}

.banner-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 3rem;
    font-weight: bold;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.container-cat {
    display: flex;
    flex-wrap: wrap;
    max-width: 1500px;
    justify-content: space-between;
}

.section-cat {
    flex: 1 1 calc(20% - 20px); /* 4 items per row with margin */
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

.section-cat:hover {
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

@media (min-width: 768px) {
    .section-cat {
        flex-basis: 20%;
        margin: 1%;
    }
}
@media (max-width: 640px) {
    .section-cat {
        flex-basis: 20%;
        margin: 1%;
    }
}
</style>

