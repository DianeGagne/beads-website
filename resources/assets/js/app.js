/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//event emitter
window.Event = new class {
    constructor(){
        this.vue = new Vue();
    }

    fire( event, data = null){
        this.vue.$emit(event,data);
    }

    listen( event, callback){
        this.vue.$on(event, callback);
    }
};

import VueTabs from 'vue-nav-tabs';
import 'vue-nav-tabs/themes/vue-tabs.css';
import vmodal from 'vue-js-modal';
import Vuex from 'vuex';

import currentBead from './store/currentBead';

Vue.use(vmodal);
Vue.use(VueTabs);
Vue.use(Vuex);

export const store = new Vuex.Store({
    namespaced: true,
    modules: {
        currentBead: currentBead,
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('register', require('./components/Registration/Register.vue'));

Vue.component('scrollpattern', require('./components/PatternDisplays/ScrollPatterns.vue'));
Vue.component('patternshow', require('./components/PatternDisplays/PatternShow.vue'));

Vue.component('patternmaker', require('./components/PatternMaker/PatternMaker.vue'));
Vue.component('new-pattern', require('./components/PatternMaker/Modals/NewPattern.vue'));
Vue.component('update-pattern', require('./components/PatternMaker/Modals/UpdatePattern.vue'));

Vue.component('action-bar', require('./components/PatternMaker/ActionBar/ActionBar.vue'));
Vue.component('action-bar-controls', require('./components/PatternMaker/ActionBar/ActionBarControls.vue'));
Vue.component('color-section', require('./components/PatternMaker/ActionBar/ActionBarSelects/ColorSection/ColorSection.vue'));
Vue.component('color-picker', require('./components/PatternMaker/ActionBar/ActionBarSelects/ColorSection/ColorPicker.vue'));
Vue.component('selected-bead', require('./components/PatternMaker/ActionBar/ActionBarSelects/SelectedBead.vue'));
Vue.component('rotate', require('./components/PatternMaker/ActionBar/ActionBarSelects/Rotate.vue'));
Vue.component('zoom', require('./components/PatternMaker/ActionBar/ActionBarSelects/Zoom.vue'));
Vue.component('pan', require('./components/PatternMaker/ActionBar/ActionBarSelects/Pan.vue'));
Vue.component('undo', require('./components/PatternMaker/ActionBar/ActionBarSelects/Undo.vue'));

Vue.component('pattern-canvas', require('./components/PatternMaker/PatternCanvas.vue'));
Vue.component('draw-brick-lines', require('./components/PatternMaker/PatternDraw/Brick/DrawBrickLines.vue'));
Vue.component('brick-bead-calc', require('./components/PatternMaker/PatternDraw/Brick/BrickBeadCalc.vue'));
Vue.component('bead', require('./components/PatternMaker/PatternDraw/Bead.vue'));

Vue.component('pattern-name', require('./components/PatternMaker/PatternValues/PatternName.vue'));
Vue.component('pattern-type', require('./components/PatternMaker/PatternValues/PatternType.vue'));
Vue.component('bead-type', require('./components/PatternMaker/PatternValues/BeadType.vue'));
Vue.component('pattern-size', require('./components/PatternMaker/PatternValues/PatternSize.vue'));

const pattern = new Vue({
    el: '#pattern',
    store,
});

const controls = new Vue({
    el: '#controls',
    store,
});

