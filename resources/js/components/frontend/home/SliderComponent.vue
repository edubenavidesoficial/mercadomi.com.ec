<template>
    <LoadingComponent :props="loading" />
    <section class="mb-10 sm:mb-10 container-custom padding-lg">
        <div>
            <Swiper v-if="sliders.length > 0" :slides-per-view="1" :speed="1000" :loop="true" :navigation="true"
                    :pagination="{ clickable: true }" :autoplay="{ delay: 2500 }" :modules="modules"
                    class="banner-swiper">
                <SwiperSlide v-for="slider in sliders" :key="slider.id">
                    <div v-if="slider.link">
                        <a :href="slider.link" class="block w-full h-full">
                             <img class="banner-image-cat" src="https://mercadomi.com.ec/storage/31/conversions/Untitled-design-cover-a.jpg" alt="banner" loading="lazy">
                        </a>
                    </div>
                    <div v-else class="block w-full h-full">
                         <img class="banner-image-cat" src="https://mercadomi.com.ec/storage/31/conversions/Untitled-design-cover-a.jpg" alt="banner" loading="lazy">
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>
    </section>
</template>

<script>
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import {Navigation, Pagination, Autoplay} from 'swiper/modules';
import {Swiper, SwiperSlide} from 'swiper/vue';
import statusEnum from "../../../enums/modules/statusEnum";
import LoadingComponent from "../components/LoadingComponent";

export default {
    name: "SliderComponent",
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
                isActive: false
            },
            sliderProps: {
                search: {
                    paginate: 0,
                    order_column: 'id',
                    order_type: 'desc',
                    status: statusEnum.ACTIVE
                }
            }
        }
    },
    computed: {
        sliders() {
            return this.$store.getters['frontendSlider/lists'];
        }
    },
    mounted() {
        this.loading.isActive = true;
        this.$store.dispatch("frontendSlider/lists", this.sliderProps.search).then(() => {
            this.loading.isActive = false;
        }).catch(() => {
            this.loading.isActive = false;
        });
    }
}
</script>

<style>
.banner-swiper {
    width: 100%;
}

.banner-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Cover the entire area without distortion */
    border-radius: 25px;
}

.banner-swiper {
    width: 100%;
}

.banner-image-cat {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Cover the entire area without distortion */
    border-radius: 25px;
}

@media (min-width: 1240px) {
    .banner-image-cat {
        border-radius: 52px;
    }
}

/* Clase CSS para el padding */
.padding-lg {
    padding-left: 1rem;
    padding-right: 1rem;
}

@media (min-width: 768px) {
    .padding-lg {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (min-width: 1200px) {
    .padding-lg {
        padding-left: 4rem;
        padding-right: 4rem;
    }
}



</style>
