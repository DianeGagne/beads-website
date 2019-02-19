class SavedPattern {

    constructor() {
        this.patternValues = {
            patternName: 'New Pattern',
            beadType: {
                name: 'delica',
                beadAspect: 1,
                beadWidth: 1.96,
                beadHeight: 1.96,
                beadWeight: .030,
            },
            stitchType: {
                name: 'brick',
            },

        };

        //Display values for the pan and zoom
        this.pan = {
            horizontal: 0,
            vertical: 0,
        };
        this.scaleFactor = 1;

        this.updateCanvas = false;



        this.palette = null;
    };
}

export default (new SavedPattern);

