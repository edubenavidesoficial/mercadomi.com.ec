<template>
    <LoadingComponent :props="loading" />
    <div class="container-custom">
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
        </div>
            <!-- Sección de Categorías Principales -->
        


</template>

<script>
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import statusEnum from "../../../enums/modules/statusEnum";
import LoadingComponent from "../components/LoadingComponent";
import ProductListComponent from "../components/ProductListComponent.vue";

export default {
    name: "CategoryComponent",
    components: {
        Swiper,
        SwiperSlide,
        LoadingComponent,
        ProductListComponent
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
            breakpoints: {
                0: { slidesPerView: 'auto', spaceBetween: 16 },
                640: { slidesPerView: 4, spaceBetween: 24 },
                768: { slidesPerView: 5, spaceBetween: 24 },
                1024: { slidesPerView: 6, spaceBetween: 24 }
            },
            selectedCategory: null,
        }
    },
    computed: {
        categories() {
            return this.$store.getters["frontendProductCategory/lists"];
        },
        products() {
            return this.$store.getters["frontendProduct/popularProducts"];
        },
        filteredProducts() {
            if (!this.selectedCategory) {
                return this.products;
            }
            return this.products.filter(product => product.category_slug === this.selectedCategory);
        },
    },
    methods: {
        filterProducts(categorySlug) {
            this.selectedCategory = categorySlug;
        },
    },
    mounted() {
        this.loading.isActive = true;
        Promise.all([
            this.$store.dispatch("frontendProductCategory/lists", {
                paginate: 0,
                order_column: "id",
                parent_id: null,
                status: statusEnum.ACTIVE,
            }),
            this.$store.dispatch("frontendProduct/popularProducts", {
                paginate: 0,
                rand: 4
            })
        ]).then(() => {
            this.loading.isActive = false;
        }).catch(() => {
            this.loading.isActive = false;
        });
    },
}
</script>

<style>
.container-mar {
    display: flex;
    max-width: 1500px;
    justify-content: space-between;
}

.section-mar {
    flex: 1 1 100%; /* Por defecto, ocupará todo el ancho en móviles */
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
    border-radius: 20px;
}

.section-mar:hover {
    transform: translateY(-5px) scale(1.03);
}

.title-m {
    margin: 0;
    font-size: 25px;
    font-weight: 900;
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

.text-yellow {
    color: #e8a623;
    text-transform: uppercase;
    font-size: 1.5rem !important;
}
.btn-filter:hover {
  background-color: #a12a24;
}
.btn-filter {
    background-color: #e8a623;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 23px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: 5px;
}
.btn-filter:hover {
    background-color: #cf362f;
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

    .btn-filter {
        padding: 8px 16px;
        font-size: 12px;
        margin: 3px;
    }
}

@media (min-width: 1024px) {
    .section-mar {
        flex: 1 1 calc(25% - 20px);
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    .container-mar {
        flex-wrap: nowrap;
    }
    
    .section-mar {
        flex: 1 1 0; /* Distribuye el espacio equitativamente */
        min-width: 0; /* Permite que se ajusten al ancho disponible */
        margin: 5px; /* Reduce el margen para que quepan las 4 secciones */
    }

    .title-m {
        font-size: 18px; /* Reduce el tamaño de la fuente para ajustarse mejor */
    }

    .button {
        padding: 8px 15px; /* Reduce el padding del botón */
        font-size: 12px; /* Reduce el tamaño de la fuente del botón */
    }
}

</style>
