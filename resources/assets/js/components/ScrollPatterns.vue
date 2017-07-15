<template>
    <div class="container">
        <div id="scrollPattern">
            <div style="display: flex;">
                <button id="scroll-left" @click="scrollLeft"><span class="glyphicon glyphicon-arrow-left"></span></button>
                <patternshow canvas-name="prev_pattern" :grid-width=prevPattern.width :grid-height=prevPattern.height :bead-matrix=prevPattern.beadMatrix ></patternshow>
                <patternshow canvas-name="current_pattern" :grid-width=current.width :grid-height=current.height :bead-matrix=current.beadMatrix ></patternshow>
                <patternshow canvas-name="next_pattern" :grid-width=nextPattern.width :grid-height=nextPattern.height :bead-matrix=nextPattern.beadMatrix ></patternshow>
                <button id="scroll-right" @click="scrollRight"><span class="glyphicon glyphicon-arrow-right"></span></button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                prevPattern: {
                    width: 5,
                    height: 6,
                    beadMatrix: null,

                },
                current: {
                    width: 7,
                    height: 7,
                    beadMatrix: null,
                },
                nextPattern: {
                    width: 8,
                    height: 8,
                    beadMatrix: null,
                }
            }
        },
        mounted() {

        },
        methods: {
            swapPattern: function(prevPattern, nextPattern) {
                console.log(prevPattern);
                console.log(nextPattern);
                prevPattern.width = nextPattern.width;
                prevPattern.height = nextPattern.height;
                prevPattern.beadMatrix = nextPattern.beadMatrix;
            },
            scrollLeft: function () {
                var self = this;
                axios.get('/pattern/next')
                    .then(function (response) {
                        console.log(response);
                        //cycle current to prevPattern, nextPattern to current & get the nextPattern
                        self.swapPattern(self.prevPattern, self.current);
                        self.swapPattern(self.current, self.nextPattern);

                        self.nextPattern.width = response.data.width;
                        self.nextPattern.height = response.data.height;
                        self.nextPattern.beadMatrix = JSON.parse(response.data.jsonPattern);
                    });
            },
            scrollRight: function () {
                var self = this;
                axios.get('/pattern/next')
                    .then(function (response) {
                        console.log(response);
                        //cycle current to prevPattern, nextPattern to current & get the nextPattern
                        self.swapPattern(self.nextPattern, self.current);
                        self.swapPattern(self.current, self.prevPattern);

                        self.prevPattern.width = response.data.width;
                        self.prevPattern.height = response.data.height;
                        self.prevPattern.beadMatrix = JSON.parse(response.data.jsonPattern);
                    });
            },
        }
    }
</script>
