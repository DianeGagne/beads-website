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
            patternSize: {
                height: 5,
                width: 30,
            }
        };
        this.actionBarValues = {
            bead: {
                color: '#666666',
                image: 'db0923',
                key: 14,
                otherValue: 'something',
            },
            panZoom: {
                scaleFactor: 1,
                pan: {
                    horizontal: 0,
                    vertical: 0,
                },
            },
        };

        this.updateCanvas = false;

        this.beadMatrix = [];

        for (let i = 0; i < this.patternValues.patternSize.width; i++) {
            this.beadMatrix.push([]);
            for (let j = 0; j < this.patternValues.patternSize.height; j++) {
                this.beadMatrix[i].push({});
            }
        }

        this.palette = null;
    };
}


export default (new SavedPattern);

