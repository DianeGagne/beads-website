<template>
    <div class="container">
        <div id="scrollPattern">
            <div style="display: flex;">
                <button id="scroll-left" @click="scrollLeft"><span class="glyphicon glyphicon-arrow-left"></span>
                </button>
                <patternshow canvas-name="prev_pattern" :canvas-height=200 :canvas-width=200 :patternInfo=prevPattern
                ></patternshow>
                <patternshow canvas-name="current_pattern" :canvas-height=centerSize :canvas-width=centerSize
                             :patternInfo=current
                             @mouseenter.native="zoomPattern"
                             @mouseleave.native="removeZoomPattern"></patternshow>
                <patternshow canvas-name="next_pattern" :canvas-height=200 :canvas-width=200
                             :patternInfo=nextPattern></patternshow>
                <button id="scroll-right" @click="scrollRight"><span class="glyphicon glyphicon-arrow-right"></span>
                </button>
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
                },
                centerSize: 400,

            }
        },
        created: function () {
            var vm = this;
            window.addEventListener('keydown', function(event){
                if(event.keyCode === 37){
                    vm.scrollLeft();
                }
                if(event.keyCode === 39){
                    vm.scrollRight();
                }
                if(event.keyCode === 32){
                    vm.zoomPattern();
                }
            });
            window.addEventListener('keyup', function(event){
                if(event.keyCode === 32){
                    vm.removeZoomPattern();
                }
            });
        },
        mounted() {

        },
        methods: {
            swapPattern: function (prevPattern, nextPattern) {
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
            zoomPattern: function () {
                this.centerSize = 600;
            },
            removeZoomPattern: function () {
                this.centerSize = 400;
            }
        }
    }
</script>
