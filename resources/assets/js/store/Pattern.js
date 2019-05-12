const state = {
    rows: 5,
    columns: 30,
    beadMatrix: [],
};

const mutations = {
    createInitialPattern(state) {
        state.beadMatrix = [];

        for (let i = 0; i < state.columns; i++) {
            state.beadMatrix.push([]);
            for (let j = 0; j < state.rows; j++) {
                state.beadMatrix[i].push({'color': '#999999'});
            }
        }
    },

    //this will only add or remove rows from the bottom of the pattern
    setHeight(state, newHeight) {
        if (newHeight > state.rows) {
            let rowsToAdd = newHeight - state.rows;

            for (let i = 0; i < state.columns; i++) {
                for (let j = 0; j < rowsToAdd; j++) {
                    state.beadMatrix[i].push({});
                }
            }
        }

        if (newHeight < state.rows) {
            let rowsToRemove = state.rows - newHeight;

            for (let i = 0; i < state.columns; i++) {
                for (let j = 0; j < rowsToRemove; j++) {
                    state.beadMatrix[i].pop();
                }
            }
        }
    },

    //this will add or remove columns from the right side of the pattern
    setWidth(state, newWidth) {
        if (newWidth > state.columns) {
            let rowsToAdd = newWidth - state.columns;

            for (let i = 0; i < rowsToAdd; i++) {
                state.beadMatrix.push([]);
                for (let j = rowsToAdd; j < state.rows; j++) {
                    state.beadMatrix[i].push({});
                }
            }
        }

        if (newWidth < state.columns) {
            let rowsToRemove = state.columns - newWidth;

            for (let i = 0; i < rowsToAdd; i++) {
                state.beadMatrix.pop();
            }
        }
    },

    /**Assume the beadLocationArray takes the form of an object (ex):
     beadLocationArray = {bead={color:#FFFFFF, key:12}, locations=[{x=1,y=1},{x=2,y=1},{x=3,y=1}])
     **/
    setBeads(state, beadLocationsArray) {
        let locations = beadLocationsArray.locations;
        for (let locationIndex in locations) {
            let indexX = locations[locationIndex].x;
            let indexY = locations[locationIndex].y;
            let yArray = state.beadMatrix[indexX];

            yArray.splice(indexY, 1, beadLocationsArray.bead);
        }
    },

};
const getters = {

    //get just the color from the pattern at the bead location
    //pass the location in the form {x=1,y=2}
    colorAtLocation: state => location => {
        if(state.beadMatrix.length != 0) {
            return state.beadMatrix[location.x - 1][location.y - 1].color;
        }
    },
    width(state, getters) {
        return state.columns;
    },
    height(state, getters) {
        return state.rows;
    },
    fullPattern(state, getters) {
        return state.beadMatrix;
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
}