    const state = {
        color: '#666666',
        image: 'db0923',
        key: 14,
        otherValue: 'something',
    };
    const mutations = {
        changeBead( state, newBead){
            state.color = newBead.color;
            state.image = newBead.image;
            state.key = newBead.key;
            state.otherValue = newBead.otherValue;
        }
    };
    const getters = {
        beadColor(state, getters) {
            return state.color;
        },
        beadImageUrl(state, getters) {
            return 'url(/assets/delica11/' + state.image + '.jpg)';
        },
        beadKey(state, getters){
            return state.key;
        },
        value(state, getters){
            return {color: state.color, key: state.key};
        },
    };

export default {
    namespaced: true,
    state,
    mutations,
    getters,
}
