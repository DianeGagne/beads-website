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
    canvasHeight: 100,
    beadWidth: 25,
    beadHeight: 25,
    pan: {
        horizontal: 0,
        vertical: 0,
    },
    scaleFactor: 1,
    beadAspect: 1,
};
const mutations = {
    setCanvasWidth(state, width) {
        state.canvasWidth = width;
    },
    setCanvasHeight(state, height) {
        state.canvasHeight = height;
    },

    panLeft(state) {
        state.pan.horizontal = state.pan.horizontal - state.beadWidth;
    },

    panRight(state) {
        state.pan.horizontal = state.pan.horizontal + state.beadWidth;
    },

    panUp(state) {
        state.pan.vertical = state.pan.vertical - state.beadHeight;
    },

    panDown(state) {
        state.pan.vertical = state.pan.vertical + state.beadHeight;
    },

    panCenter(state) {
        state.pan.horizontal = 0;
        state.pan.vertical = 0;
    },
    /**
     * set the pan in the form {horizontal: 1, vertical: 1}
     * @param state
     * @param width
     */
    setPan(state, width) {
    },

    zoomIn(state) {
        state.scaleFactor = state.scaleFactor + .25;
    },
    zoomOut(state) {
        if(state.scaleFactor > .25) {
            state.scaleFactor = state.scaleFactor - .25;
        }
    },
    zoomDefault(state) {
        state.scaleFactor = 1;
    },

    //determine if the pattern goes all the way to the height edges or the width edges.
    //To display the entire pattern on the screen as large as possible one must be true
    //NOTE: this currently assumes beads are a 1:1 ratio height:width - this is true for delica beads
    setHeightLimited(state) {

    }
};
const getters = {
    canvasWidth(state) {
        return state.canvasWidth;
    },
    heightLimited(state, getters, rootState) {
        let proportionHeightCovered = rootState.pattern.columns / state.canvasHeight;
        let proportionWidthCovered = rootState.pattern.rows / state.canvasWidth;

        return proportionHeightCovered < proportionWidthCovered;
    },

    beadHeight(state, getters, rootState) {
        let baseBeadHeight = 1;

        //If our pattern takes up more vertical space on our screen than horizontal
        if (getters.heightLimited) {
            //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
            let smallestOffsetPossible = (state.canvasHeight % rootState.pattern.rows) / 2;

            //Calculate the bead size - based on the smallest offsets possible & the current zoom
            baseBeadHeight = (state.canvasHeight - smallestOffsetPossible) / rootState.pattern.rows;
        } else {
            //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
            let smallestOffsetPossible = (state.canvasWidth % (rootState.pattern.columns * state.beadAspect)) / 2;

            let baseBeadWidth = (state.canvasWidth - smallestOffsetPossible) / (rootState.pattern.columns * state.beadAspect);
            baseBeadHeight = baseBeadWidth / state.beadAspect;
        }

        return baseBeadHeight * state.scaleFactor;
    },
    beadWidth(state, getters, rootState) {
        let baseBeadHeight = 1;
        let baseBeadWidth = 1;
        //If our pattern takes up more vertical space on our screen than horizontal
        if (getters.heightLimited) {
            //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
            let smallestOffsetPossible = (state.canvasHeight % rootState.pattern.rows) / 2;

            //Calculate the bead size - based on the smallest offsets possible & the current zoom
            baseBeadHeight = (state.canvasHeight - smallestOffsetPossible) / rootState.pattern.rows;
            baseBeadWidth = baseBeadHeight * state.beadAspect;
        } else {
            //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
            let smallestOffsetPossible = (state.canvasWidth % (rootState.pattern.columns * state.beadAspect)) / 2;

            baseBeadWidth = (state.canvasWidth - smallestOffsetPossible) / (rootState.pattern.columns * state.beadAspect);
        }

        //apply the scale factor to the bead size
        return baseBeadWidth * state.scaleFactor;
    },
    totalPatternWidth(state, getters, rootState) {
        return getters.beadWidth * rootState.pattern.columns;
    },
    totalPatternHeight(state, getters, rootState) {
        return getters.beadHeight * rootState.pattern.rows;
    },
    leftOffset(state, getters, rootState) {
        let baseOffset = (state.canvasWidth - getters.totalPatternWidth) / 2;
        return baseOffset + state.pan.horizontal + 0.5;
    },
    horizontalEndOfPattern(state, getters, rootState) {
        return getters.leftOffset + (getters.beadWidth * rootState.pattern.columns);
    },
    topOffset(state, getters) {
        let baseOffset = (state.canvasHeight - getters.totalPatternHeight) / 2;
        return baseOffset + state.pan.vertical + 0.5;
    },
    verticalEndOfPattern(state, getters, rootState) {
        return getters.topOffset + (getters.beadHeight * rootState.pattern.rows);
    },
    beadTop: (state, getters) => (location) => {
        return (location.y) * getters.beadHeight + getters.topOffset;
    },
    beadLeft: (state, getters) => location => {
        return (location.x) * getters.beadWidth + getters.leftOffset;
    },

    //given a location (x,y) determine if the pixels are within the beaded pattern or outside of it
    isLocationInPattern: (state, getters) => location => {
        //check the location is within the pattern
        if (location.x < getters.leftOffset)
            return false;
        if (location.y < getters.topOffset)
            return false;
        if (location.x > getters.horizontalEndOfPattern)
            return false;
        if (location.y > getters.verticalEndOfPattern)
            return false;

        return true;
    },
    //get given a location in pixels (x,y) and return a location of the bead (row, column),
    //or return null if not in the pattern
    getBeadFromPixels: (state, getters) => location => {
        if (getters.isLocationInPattern) {
            //it is in the pattern - get the column
            let column = Math.floor((location.x - getters.leftOffset) / getters.beadWidth);
            let row = Math.floor((location.y - getters.topOffset) / getters.beadHeight);
            return {'column': column, 'row': row};
        }
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
}

