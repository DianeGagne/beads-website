const state = {
    rowHeight: 0,
    columnWidth: 0,
    leftOffset: 0,
    rightOffset: 0,
    topOffset: 0,
    bottomOffset: 0,
    pixelHeight: 0,
    pixelWidth: 0,

    canvasWidth: 100,


    pan: {
        horizontal: 0,
        vertical: 0,
    },
    scaleFactor: 1,

};

const mutations = {
    setCanvasWidth(state, width) {
        state.canvasWidth = width;
    },
    /**
     * set the pan in the form {horizontal: 1, vertical: 1}
     * @param state
     * @param width
     */
    setPan(state, width) {

    }
};
const getters = {
    canvasWidth(state, getters) {
        return state.canvasWidth;
    },
    rowHeight(state, getters) {

    },
    columnWidth(state, getters) {

    },

};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
}