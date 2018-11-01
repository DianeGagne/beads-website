// patternValues =
//     {
//         patternValue: {
//             patternName: 'New Pattern',
//             beadType: {
//                 name: 'delica',
//                 beadAspect: 1,
//                 beadWidth: 1.96,
//                 beadHeight: 1.96,
//                 beadWeight: .030,
//             },
//             stitchType: {
//                 name: 'brick',
//             },
//             patternSize: {
//                 height: 30,
//                 width: 30,
//             }
//         },
//         actionBarValues: {
//             bead: {
//                 color: '#666666',
//                 image: 'db0023',
//                 key: 14,
//                 otherValue: 'something',
//             },
//             signals: {
//                 //signals that trigger an action on the main pattern
//                 //they will trigger the action on true, then be set to false again.
//                 rotations: {
//                     rotateLeft: false,
//                     rotateRight: false,
//                     flipX: false,
//                     flipY: false,
//                 },
//                 undo: false,
//                 redo: false,
//                 redraw: false,
//             },
//             panZoom: {
//                 scaleFactor: 1,
//                 pan: {
//                     horizontal: 0,
//                     vertical: 0,
//                 },
//             },
//         },
//
//         beadMatrix: [],
//         palette: null
//     };

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
            signals: {
                //signals that trigger an action on the main pattern
                //they will trigger the action on true, then be set to false again.
                rotations: {
                    rotateLeft: false,
                    rotateRight: false,
                    flipX: false,
                    flipY: false,
                },
                undo: false,
                redo: false,
                redraw: false,
            },
            panZoom: {
                scaleFactor: 1,
                pan: {
                    horizontal: 0,
                    vertical: 0,
                },
            },
        };

        this.beadMatrix = [];

        for (let i = 0; i < this.patternValues.patternSize.width; i++) {
            this.beadMatrix[i] = [];
            for (let j = 0; j < this.patternValues.patternSize.height; j++) {
                this.beadMatrix[i][j] = {};
            }
        }

        this.palette = null;
    };
}

export default (new SavedPattern);