<template>
    <LoadingComponent :props="loading" />

    <footer class="pt-12 bg-mercadoni mobile:hidden">
        <div class="container">
            <div class="row">
                <p></p>
                <div class="col-12 md:col-4 lg:col-5 mb-6 md:mb-0">
                    <div class="tablet:text-center tablet:mx-auto w-full max-w-xs">
                        <router-link :to="{ name: 'frontend.home' }">
                            <img class="mb-8 w-36" :src="setting.theme_footer_logo" alt="logo" loading="lazy">
                        </router-link>

                        <form @submit.prevent="saveSubscription" class="mt-5 mb-6 block">
                            <label class="mb-3 font-medium text-yellow">
                                {{ $t('message.subscribe_to_our_newsletter') }}
                            </label>
                            <div class="flex w-full h-10 rounded-3xl p-1 bg-white">
                                <input type="email" v-model="subscriptionProps.post.email"
                                    :placeholder="$t('label.your_email_address')" class="w-full h-full pl-3 pr-2">
                                <button type="submit"
                                    class="text-xs font-semibold capitalize flex-shrink-0 px-3 h-full rounded-3xl bg-primary text-yellow">
                                    {{ $t('button.subscribe') }}
                                </button>
                            </div>
                        </form>
                        <nav v-if="setting.social_media_facebook || setting.social_media_twitter || setting.social_media_instagram || setting.social_media_youtube"
                            class="flex flex-wrap items-center gap-6 tablet:justify-center">
                            <a v-if="setting.social_media_facebook" target="_blank" :href="setting.social_media_facebook"
                                class="lab-fill-facebook w-7 h-7 !leading-7 text-center rounded-full text-sm text-secondary bg-white transition-all duration-300 hover:text-white hover:bg-primary"></a>
                            <a v-if="setting.social_media_twitter" target="_blank" :href="setting.social_media_twitter"
                                class="lab-fill-x w-7 h-7 !leading-7 text-center rounded-full text-sm text-secondary bg-white transition-all duration-300 hover:text-white hover:bg-primary"></a>
                            <a v-if="setting.social_media_instagram" target="_blank" :href="setting.social_media_instagram"
                                class="lab-fill-instagram w-7 h-7 !leading-7 text-center rounded-full text-sm text-secondary bg-white transition-all duration-300 hover:text-white hover:bg-primary"></a>
                            <a v-if="setting.social_media_youtube" target="_blank" :href="setting.social_media_youtube"
                                class="lab-fill-youtube w-7 h-7 !leading-7 text-center rounded-full text-sm text-secondary bg-white transition-all duration-300 hover:text-white hover:bg-primary"></a>
                        </nav>
                    </div>
                </div>
                <div class="col-12 md:col-8 lg:col-7">
                    <div class="row">
                        <div class="col-6 sm:col-4 mb-4 sm:mb-0">
                            <h4 class="text-[22px] font-semibold capitalize text-yellow">{{ $t('label.support') }}</h4>
                             <div class="custom-divider">
        <span class="custom-divider-separator"></span>
    </div>

                            <nav v-if="supportPages.length > 0" class="flex flex-col gap-4">
                                <router-link v-for="supportPage in supportPages"
                                    class="w-fit text-sm font-medium capitalize text-white transition-all duration-300 hover:text-primary"
                                    :to="{ name: 'frontend.page', params: { slug: supportPage.slug } }">
                                    {{ supportPage.title }}
                                </router-link>
                            </nav>
                        </div>
                        <div class="col-6 sm:col-4 mb-4 sm:mb-0">
                            <h4 class="text-[22px] font-semibold capitalize text-yellow">{{ $t('label.legal') }}</h4>
                             <div class="custom-divider">
        <span class="custom-divider-separator"></span>
    </div>

                            <nav v-if="legalPages.length > 0" class="flex flex-col gap-4">
                                <router-link v-for="legalPage in legalPages"
                                    class="w-fit text-sm font-medium capitalize text-white transition-all duration-300 hover:text-primary"
                                    :to="{ name: 'frontend.page', params: { slug: legalPage.slug } }">
                                    {{ legalPage.title }}
                                </router-link>
                            </nav>
                        </div>
                        <div class="col-12 sm:col-4">
                            <h4 class="text-[22px] font-semibold capitalize text-yellow">
                                {{ $t('label.contact') }}</h4>
                                 <div class="custom-divider">
        <span class="custom-divider-separator"></span>
    </div>

                            <ul class="flex flex-col gap-5">
                                <li class="flex gap-3">
                                    <i class="lab-fill-location text-sm flex-shrink-0 text-white"></i>
                                    <span class="text-sm font-medium text-white">{{ setting.company_address }}</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="lab-fill-mail text-sm flex-shrink-0 text-white"></i>
                                    <span class="text-sm font-medium text-white">{{ setting.company_email }}</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="lab-fill-calling text-sm flex-shrink-0 text-white"></i>
                                    <span class="text-sm font-medium text-white">{{ setting.company_phone }}</span>
                                </li>
                            </ul>

                            <dl class="mt-6">
                                <dd class="flex gap-3">
                                    <a target="_blank" class="router-link-active router-link-exact-active"
                                        v-if="setting.site_android_app_link" :href="setting.site_android_app_link">
                                        <img class="h-8 rounded-lg" :src="setting.image_play_store" alt="app"
                                            loading="lazy">
                                    </a>
                                    <a target="_blank" class="router-link-active router-link-exact-active"
                                        v-if="setting.site_ios_app_link" :href="setting.site_ios_app_link">
                                        <img class="h-8 rounded-lg" :src="setting.image_app_store" alt="app" loading="lazy">
                                    </a>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mercadoni_fin e-con-full e-flex e-con e-parent" data-id="236622f" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" bis_skin_checked="1">
		<div class=" e-flex e-con-boxed e-con e-child" data-id="f4ca1ec" data-element_type="container" bis_skin_checked="1">
					<div class="e-con-inner" bis_skin_checked="1">
				<div class=" -ed0e7f9 elementor-widget elementor-widget-text-editor" data-id="ed0e7f9" data-element_type="widget" data-widget_type="text-editor.default" bis_skin_checked="1">
				<div class="elementor-widget-container" bis_skin_checked="1">
							<p class="p-mar">Copiright @ 2024 <strong>Mercadomi</strong>. Todos los derechos reservados {{ setting.site_copyright }}</p>						</div>
				</div>
					</div>
				</div>
		<div class=" -1072e1e e-flex e-con-boxed e-con e-child" data-id="1072e1e" data-element_type="container" bis_skin_checked="1">
					<div class="e-con-inner" bis_skin_checked="1">
				<div class=" -dc69ec4 e-grid-align-right elementor-shape-rounded elementor-grid-0 elementor-widget elementor-widget-social-icons" data-id="dc69ec4" data-element_type="widget" data-widget_type="social-icons.default" bis_skin_checked="1">
				<div class="elementor-widget-container" bis_skin_checked="1">
					<div class="mercadoni-social-icon elementor-grid" bis_skin_checked="1">
							<span class="elementor-grid-item">
					<a class="icon-mar mercadoni-social-icon mercadoni-social-icon-cc-visa" target="_blank">

						<svg class="e-font-icon-svg e-fab-cc-visa" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M470.1 231.3s7.6 37.2 9.3 45H446c3.3-8.9 16-43.5 16-43.5-.2.3 3.3-9.1 5.3-14.9l2.8 13.4zM576 80v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM152.5 331.2L215.7 176h-42.5l-39.3 106-4.3-21.5-14-71.4c-2.3-9.9-9.4-12.7-18.2-13.1H32.7l-.7 3.1c15.8 4 29.9 9.8 42.2 17.1l35.8 135h42.5zm94.4.2L272.1 176h-40.2l-25.1 155.4h40.1zm139.9-50.8c.2-17.7-10.6-31.2-33.7-42.3-14.1-7.1-22.7-11.9-22.7-19.2.2-6.6 7.3-13.4 23.1-13.4 13.1-.3 22.7 2.8 29.9 5.9l3.6 1.7 5.5-33.6c-7.9-3.1-20.5-6.6-36-6.6-39.7 0-67.6 21.2-67.8 51.4-.3 22.3 20 34.7 35.2 42.2 15.5 7.6 20.8 12.6 20.8 19.3-.2 10.4-12.6 15.2-24.1 15.2-16 0-24.6-2.5-37.7-8.3l-5.3-2.5-5.6 34.9c9.4 4.3 26.8 8.1 44.8 8.3 42.2.1 69.7-20.8 70-53zM528 331.4L495.6 176h-31.1c-9.6 0-16.9 2.8-21 12.9l-59.7 142.5H426s6.9-19.2 8.4-23.3H486c1.2 5.5 4.8 23.3 4.8 23.3H528z"></path></svg>					</a>
				</span>
							<span class="elementor-grid-item">
					<a class="icon-mar mercadoni-social-icon" target="_blank">

						<svg class="e-font-icon-svg e-fab-cc-mastercard" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M482.9 410.3c0 6.8-4.6 11.7-11.2 11.7-6.8 0-11.2-5.2-11.2-11.7 0-6.5 4.4-11.7 11.2-11.7 6.6 0 11.2 5.2 11.2 11.7zm-310.8-11.7c-7.1 0-11.2 5.2-11.2 11.7 0 6.5 4.1 11.7 11.2 11.7 6.5 0 10.9-4.9 10.9-11.7-.1-6.5-4.4-11.7-10.9-11.7zm117.5-.3c-5.4 0-8.7 3.5-9.5 8.7h19.1c-.9-5.7-4.4-8.7-9.6-8.7zm107.8.3c-6.8 0-10.9 5.2-10.9 11.7 0 6.5 4.1 11.7 10.9 11.7 6.8 0 11.2-4.9 11.2-11.7 0-6.5-4.4-11.7-11.2-11.7zm105.9 26.1c0 .3.3.5.3 1.1 0 .3-.3.5-.3 1.1-.3.3-.3.5-.5.8-.3.3-.5.5-1.1.5-.3.3-.5.3-1.1.3-.3 0-.5 0-1.1-.3-.3 0-.5-.3-.8-.5-.3-.3-.5-.5-.5-.8-.3-.5-.3-.8-.3-1.1 0-.5 0-.8.3-1.1 0-.5.3-.8.5-1.1.3-.3.5-.3.8-.5.5-.3.8-.3 1.1-.3.5 0 .8 0 1.1.3.5.3.8.3 1.1.5s.2.6.5 1.1zm-2.2 1.4c.5 0 .5-.3.8-.3.3-.3.3-.5.3-.8 0-.3 0-.5-.3-.8-.3 0-.5-.3-1.1-.3h-1.6v3.5h.8V426h.3l1.1 1.4h.8l-1.1-1.3zM576 81v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V81c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM64 220.6c0 76.5 62.1 138.5 138.5 138.5 27.2 0 53.9-8.2 76.5-23.1-72.9-59.3-72.4-171.2 0-230.5-22.6-15-49.3-23.1-76.5-23.1-76.4-.1-138.5 62-138.5 138.2zm224 108.8c70.5-55 70.2-162.2 0-217.5-70.2 55.3-70.5 162.6 0 217.5zm-142.3 76.3c0-8.7-5.7-14.4-14.7-14.7-4.6 0-9.5 1.4-12.8 6.5-2.4-4.1-6.5-6.5-12.2-6.5-3.8 0-7.6 1.4-10.6 5.4V392h-8.2v36.7h8.2c0-18.9-2.5-30.2 9-30.2 10.2 0 8.2 10.2 8.2 30.2h7.9c0-18.3-2.5-30.2 9-30.2 10.2 0 8.2 10 8.2 30.2h8.2v-23zm44.9-13.7h-7.9v4.4c-2.7-3.3-6.5-5.4-11.7-5.4-10.3 0-18.2 8.2-18.2 19.3 0 11.2 7.9 19.3 18.2 19.3 5.2 0 9-1.9 11.7-5.4v4.6h7.9V392zm40.5 25.6c0-15-22.9-8.2-22.9-15.2 0-5.7 11.9-4.8 18.5-1.1l3.3-6.5c-9.4-6.1-30.2-6-30.2 8.2 0 14.3 22.9 8.3 22.9 15 0 6.3-13.5 5.8-20.7.8l-3.5 6.3c11.2 7.6 32.6 6 32.6-7.5zm35.4 9.3l-2.2-6.8c-3.8 2.1-12.2 4.4-12.2-4.1v-16.6h13.1V392h-13.1v-11.2h-8.2V392h-7.6v7.3h7.6V416c0 17.6 17.3 14.4 22.6 10.9zm13.3-13.4h27.5c0-16.2-7.4-22.6-17.4-22.6-10.6 0-18.2 7.9-18.2 19.3 0 20.5 22.6 23.9 33.8 14.2l-3.8-6c-7.8 6.4-19.6 5.8-21.9-4.9zm59.1-21.5c-4.6-2-11.6-1.8-15.2 4.4V392h-8.2v36.7h8.2V408c0-11.6 9.5-10.1 12.8-8.4l2.4-7.6zm10.6 18.3c0-11.4 11.6-15.1 20.7-8.4l3.8-6.5c-11.6-9.1-32.7-4.1-32.7 15 0 19.8 22.4 23.8 32.7 15l-3.8-6.5c-9.2 6.5-20.7 2.6-20.7-8.6zm66.7-18.3H408v4.4c-8.3-11-29.9-4.8-29.9 13.9 0 19.2 22.4 24.7 29.9 13.9v4.6h8.2V392zm33.7 0c-2.4-1.2-11-2.9-15.2 4.4V392h-7.9v36.7h7.9V408c0-11 9-10.3 12.8-8.4l2.4-7.6zm40.3-14.9h-7.9v19.3c-8.2-10.9-29.9-5.1-29.9 13.9 0 19.4 22.5 24.6 29.9 13.9v4.6h7.9v-51.7zm7.6-75.1v4.6h.8V302h1.9v-.8h-4.6v.8h1.9zm6.6 123.8c0-.5 0-1.1-.3-1.6-.3-.3-.5-.8-.8-1.1-.3-.3-.8-.5-1.1-.8-.5 0-1.1-.3-1.6-.3-.3 0-.8.3-1.4.3-.5.3-.8.5-1.1.8-.5.3-.8.8-.8 1.1-.3.5-.3 1.1-.3 1.6 0 .3 0 .8.3 1.4 0 .3.3.8.8 1.1.3.3.5.5 1.1.8.5.3 1.1.3 1.4.3.5 0 1.1 0 1.6-.3.3-.3.8-.5 1.1-.8.3-.3.5-.8.8-1.1.3-.6.3-1.1.3-1.4zm3.2-124.7h-1.4l-1.6 3.5-1.6-3.5h-1.4v5.4h.8v-4.1l1.6 3.5h1.1l1.4-3.5v4.1h1.1v-5.4zm4.4-80.5c0-76.2-62.1-138.3-138.5-138.3-27.2 0-53.9 8.2-76.5 23.1 72.1 59.3 73.2 171.5 0 230.5 22.6 15 49.5 23.1 76.5 23.1 76.4.1 138.5-61.9 138.5-138.4z"></path></svg>					</a>
				</span>
							<span class="elementor-grid-item">
					<a class="icon-mar mercadoni-social-icon " target="_blank">

						<svg class="e-font-icon-svg e-fab-cc-discover" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M520.4 196.1c0-7.9-5.5-12.1-15.6-12.1h-4.9v24.9h4.7c10.3 0 15.8-4.4 15.8-12.8zM528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-44.1 138.9c22.6 0 52.9-4.1 52.9 24.4 0 12.6-6.6 20.7-18.7 23.2l25.8 34.4h-19.6l-22.2-32.8h-2.2v32.8h-16zm-55.9.1h45.3v14H444v18.2h28.3V217H444v22.2h29.3V253H428zm-68.7 0l21.9 55.2 22.2-55.2h17.5l-35.5 84.2h-8.6l-35-84.2zm-55.9-3c24.7 0 44.6 20 44.6 44.6 0 24.7-20 44.6-44.6 44.6-24.7 0-44.6-20-44.6-44.6 0-24.7 20-44.6 44.6-44.6zm-49.3 6.1v19c-20.1-20.1-46.8-4.7-46.8 19 0 25 27.5 38.5 46.8 19.2v19c-29.7 14.3-63.3-5.7-63.3-38.2 0-31.2 33.1-53 63.3-38zm-97.2 66.3c11.4 0 22.4-15.3-3.3-24.4-15-5.5-20.2-11.4-20.2-22.7 0-23.2 30.6-31.4 49.7-14.3l-8.4 10.8c-10.4-11.6-24.9-6.2-24.9 2.5 0 4.4 2.7 6.9 12.3 10.3 18.2 6.6 23.6 12.5 23.6 25.6 0 29.5-38.8 37.4-56.6 11.3l10.3-9.9c3.7 7.1 9.9 10.8 17.5 10.8zM55.4 253H32v-82h23.4c26.1 0 44.1 17 44.1 41.1 0 18.5-13.2 40.9-44.1 40.9zm67.5 0h-16v-82h16zM544 433c0 8.2-6.8 15-15 15H128c189.6-35.6 382.7-139.2 416-160zM74.1 191.6c-5.2-4.9-11.6-6.6-21.9-6.6H48v54.2h4.2c10.3 0 17-2 21.9-6.4 5.7-5.2 8.9-12.8 8.9-20.7s-3.2-15.5-8.9-20.5z"></path></svg>					</a>
				</span>
							<span class="elementor-grid-item">
					<a class="icon-mar mercadoni-social-icon" target="_blank">

						<svg class="e-font-icon-svg e-fab-cc-diners-club" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M239.7 79.9c-96.9 0-175.8 78.6-175.8 175.8 0 96.9 78.9 175.8 175.8 175.8 97.2 0 175.8-78.9 175.8-175.8 0-97.2-78.6-175.8-175.8-175.8zm-39.9 279.6c-41.7-15.9-71.4-56.4-71.4-103.8s29.7-87.9 71.4-104.1v207.9zm79.8.3V151.6c41.7 16.2 71.4 56.7 71.4 104.1s-29.7 87.9-71.4 104.1zM528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM329.7 448h-90.3c-106.2 0-193.8-85.5-193.8-190.2C45.6 143.2 133.2 64 239.4 64h90.3c105 0 200.7 79.2 200.7 193.8 0 104.7-95.7 190.2-200.7 190.2z"></path></svg>					</a>
				</span>
					</div>
				</div>
				</div>
					</div>
				</div>
				</div>
    </footer>
</template>


<script>
import statusEnum from "../../../enums/modules/statusEnum";
import axios from "axios";
import alertService from "../../../services/alertService";
import LoadingComponent from "../../frontend/components/LoadingComponent";
import menuSectionEnum from "../../../enums/modules/menuSectionEnum";
import _ from "lodash";

export default {
    name: "FrontendFooterComponent",
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            legalPages: [],
            supportPages: [],
            enums: {
                statusEnum: statusEnum,
                menuSectionEnum: menuSectionEnum
            },
            subscriptionProps: {
                post: {
                    email: ""
                }
            }
        }
    },
    computed: {
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        }
    },
    mounted() {
        this.loading.isActive = true;
        this.$store.dispatch("frontendPage/lists", {
            paginate: 0,
            order_column: "id",
            order_type: "asc",
            status: this.enums.statusEnum.ACTIVE
        }).then(res => {
            if (res.data.data.length > 0) {
                _.forEach(res.data.data, (page) => {
                    if (page.menu_section_id === this.enums.menuSectionEnum.LEGAL) {
                        this.legalPages.push(page);
                    } else {
                        this.supportPages.push(page);
                    }
                });
            }
            this.loading.isActive = false;
        }).catch((err) => {
            this.loading.isActive = false;
        });
    },
    methods: {
        saveSubscription: function () {
            const url = '/frontend/subscriber';
            this.loading.isActive = true;
            axios.post(url, this.subscriptionProps.post).then(res => {
                this.loading.isActive = false;
                this.subscriptionProps.post.email = "";
                alertService.success(this.$t("message.subscribe"));
            }).catch((err) => {
                this.loading.isActive = false;
            });
        }
    }
}
</script>
<style>
.bg-mercadoni {
    --tw-bg-opacity: 1;
    background-color: rgb(40 40 40 / var(--tw-bg-opacity));
}
.mercadoni_fin {
    display: flex !important;
    min-height: 90px !important;
    flex-direction: row !important;
    width: initial !important; /* Cambiado de --container-widget-width */
    height: 100% !important; /* Cambiado de --container-widget-height */
    flex-grow: 1 !important; /* Cambiado de --container-widget-flex-grow */
    align-self: stretch !important; /* Cambiado de --container-widget-align-self */
    justify-content: space-evenly !important;
    transition: background 0.3s !important; /* Cambiado de --background-transition */
    background-color: #363636;
}

.mercadoni-social-icon {
    color: #fff;
    margin: 25px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    cursor: pointer;
}

.elementor *, .elementor :after, .elementor :before {
    box-sizing: border-box;
}
.elementor-widget-divider:not(.elementor-widget-divider--view-line_text):not(.elementor-widget-divider--view-line_icon) .elementor-divider-separator {
    border-block-start: var(--divider-border-width) var(--divider-border-style) var(--divider-color);
}
.elementor-111 .elementor-element.elementor-element-211d881 .elementor-divider-separator {
    width: 20%;
    margin: 0 auto;
    margin-left: 0;
}
.icon-mar {
    width: 1em;
    height: 1em;
    position: relative;
    display: block;
}
.p-mar {
    margin: 40px;
    color: white;
}
.text-yellow{
    color: #E8A623;
}
.custom-divider-separator {
    border-block-start: 2px solid #E8A623; /* Aplicando el color directamente */
    width: 20%;
    margin: 0 auto;
    margin-left: 0;
}

</style>
