const state = {
    rows: 5,
    columns: 10,
    beadMatrix: [],
    updatedLocations: [],
};

const mutations = {
    handleUpdate(state, index) {
        state.updatedLocations[index].handled = true;

        if(state.updatedLocations.length > 50){
            state.updatedLocations.splice(20, state.updatedLocations.length);
        }
    },

    createInitialPattern(state) {
        state.beadMatrix = [];

        for (let i = 0; i < state.columns; i++) {
            state.beadMatrix[i] = [];
            for (let j = 0; j < state.rows; j++) {
                state.beadMatrix[i][j] = {'color': '#999999', 'key': 0};
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

            //check if the update needs to be applied
            let oldBead = state.beadMatrix[indexX][indexY].key;
            if(oldBead !== beadLocationsArray.bead.key) {
                console.log('still updating ' + oldBead + ' ' + beadLocationsArray.bead.key);
                state.beadMatrix[indexX][indexY] = beadLocationsArray.bead;
                state.updatedLocations.push({'action': 'drawBead', 'location': locations, 'bead': beadLocationsArray.bead, 'handled': false});
            }
        }
    },

    rotateLeft(state){
        //initialize an empty array
        let newArray = [];

        let newColumns = state.rows;
        let newRows = state.columns;

        //initialize an empty matrix
        for(let currentColumn = 0; currentColumn < newColumns; currentColumn++)
        {
            newArray[currentColumn] = [];
        }

        for ( let currentColumn = 0; currentColumn<newColumns; currentColumn++) {
            for (let currentRow = 0; currentRow < newRows; currentRow++) {
                newArray[currentColumn][currentRow] = state.beadMatrix[state.columns - 1 - currentRow][currentColumn];
            }
        }

        state.beadMatrix = newArray;
        let currentColumns = state.columns;
        state.columns = state.rows;
        state.rows = currentColumns;

        state.updatedLocations.push({'action': 'rotateLeft', 'handled': false});
    },
    rotateRight(state){

        //initialize an empty array
        let newArray = [];

        let newColumns = state.rows;
        let newRows = state.columns;

        //initialize an empty matrix
        for(let currentColumn = 0; currentColumn < newColumns; currentColumn++)
        {
            newArray[currentColumn] = [];
        }

        for ( let currentColumn = 0; currentColumn<newColumns; currentColumn++) {
            for (let currentRow = 0; currentRow < newRows; currentRow++) {
                newArray[currentColumn][currentRow] = state.beadMatrix[currentRow][state.rows - 1 - currentColumn];
            }
        }

        state.beadMatrix = newArray;
        let currentColumns = state.columns;
        state.columns = state.rows;
        state.rows = currentColumns;

        state.updatedLocations.push({'action': 'rotateRight', 'handled': false});
    },
    flipX(state){
        let movingArray = [];

        for (let i = 0; i < state.columns /2 ; i++) {
            movingArray = state.beadMatrix[i];
            state.beadMatrix[i] = state.beadMatrix[state.columns - i - 1];
            state.beadMatrix[state.columns - i -1] = movingArray;
        }

        state.updatedLocations.push({'action': 'flipX', 'handled': false});
    },
    flipY(state){
        let movingValue;

        for (let i = 0; i < state.columns; i++) {
            for (let j = 0; j < state.rows /2; j++) {
                movingValue = state.beadMatrix[i][j];
                state.beadMatrix[i][j] = state.beadMatrix[i][state.rows - j - 1];
                state.beadMatrix[i][state.rows - j - 1] = movingValue;
            }
        }

        state.updatedLocations.push({'action': 'flipY', 'handled': false});
    },

};
const getters = {

    //get just the color from the pattern at the bead location
    //pass the location in the form {x=1,y=2}
    colorAtLocation: state => location => {
        if(state.beadMatrix.length != 0) {
            return state.beadMatrix[location.x][location.y].color;
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