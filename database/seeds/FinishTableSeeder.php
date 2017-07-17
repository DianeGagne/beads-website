<?php

use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: Diane
 * Date: 8/9/2015
 * Time: 2:05 PM
 */
class FinishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dyed = App\Finishes::create(array('name' => 'Dyed'));
        $dyed->beads()->attach([

            39,
            40,
            41,
            42,
            43,
            44,
            45,
            46,
            47,
            48,
            49,
            50,
            51,
            52,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60,
            61,
            62,
            63,
            64,
            65,
            66,
            67,
            68,
            69,
            70,
            71,
            72,
            73,
            74,
            75,
            76,
            77,

            177,
            178,
            179,
            180,
            181,
            182,
            183,
            184,
            185,
            186,
            187,
            188,
            189,
            190,
            191,
            192,
            193,
            194,
            195,

            200,
            201,

            210,
            211,
            212,
            213,
            214,
            215,
            216,
            217,
            218,
            219,
            220,
            221,
            222,
            223,
            224,
            225,
            226,
            227,
            228,
            229,
            230,

            281,
            282,
            283,
            284,
            285,
            286,
            287,
            288,
            289,
            290,
            291,
            292,
            293,
            294,
            295,
            296,
            297,
            298,
            299,
            300,
            301,
            302,
            303,
            304,
            305,
            306,
            307,
            308,
            309,
            310,
            311,
            312,
            313,
            314,
            315,
            316,
            317,
            318,
            319,
            320,
            321,
            322,
            342,
            343,
            344,
            345,
            346,
            347,
            348,
            349,
            350,
            351,
            352,
            353,
            354,
            355,
            356,
            357,
            358,
            359,
            360,
            361,
            362,
            363,
            364,
            365,

            367,
            368,
            369,
            370,
            371,
            372,
            373,
            374,
            375,
            376,
            377,
            378,
            379,
            380,

            392,
            393,
            394,
            395,
            396,
            397,
            398,
            399,
            400,
            401,
            402,
            403,
            404,
            405,
            406,
            407,
            408,

            467,
            468,
            469,
            470,
            471,
            472,
            473,
            474,
            475,
            476,
            477,
            478,
            479,
            480,
            481,
            482,
            483,
            484,
            485,
            486,
            487,
            488,
            489,
            490,
            491,
            492,
            493,
            494,

            543,
            544,
            545,
            546,
            547,
            548,
            549,
            550,
            551,
            552,
            553,
            554,
            555,
            556,
            557,
            558,
            559,
            560,
            561,
            562,
            563,
            564,
            565,
            566,
            567,
            568,
            569,
            570,
            571,
            572,
            573,

            621,
            622,
            623,
            624,
            625,
            626,
            627,
            628,
            629,
            630,
            631,
            632,
            633,
            634,
            635,
            636,
            637,
            638,
            639,
            640,
            641,
            642,
            643,
            644,
            645,
            646,
            647,
            648,

            699,
            700,
            701,
            702,
            703,
            704,
            705,
            706,
            707,
            708,
            709,
            710,
            711,
            712,
            713,
            714,
            715,
            716,
            717,
            718,
            719,
            720,

            880,
            881,
            882,
            883,
            884,
            885,
            886,
            887,
            888,
            889,
            890,
            891,
            892,
            893,
            894,
            895,
            896,
            897,
            898,
            899,
            900,
            901,
            902,
            903,
            904,
            905,
            906,
            907,
            908,
            909,
            910,
            911,
            912,
            913,
            914,
            915,
            916,
            917,
            918,
            919,
            920,
            921,
            922,
            923,
            924,
            925,
            926,
            927,
            928,
            929,
            930,
            931,
            932,
            933,
            934,
            935,
            936,
            937,
            938,
            939,
            940,
            941,
            942,
            943,
            944,
            945,
            946,
            947,
            948,
            949,
            950,
            951,
            952,
            953,
            954,
            955,
            956,
            957,
            958,
            959,
            960,
        ]);


        $solgel = App\Finishes::create(array('name' => 'Sol-gel'));

        $luster = App\Finishes::create(array('name' => 'Luster'));
        $luster->beads()->attach([

            17,
            18,

            37,

            81,
            82,
            83,
            84,
            85,
            86,
            87,
            88,
            89,
            90,
            91,
            92,
            93,
            94,
            95,
            96,
            97,
            98,
            99,
            100,
            101,
            102,
            103,
            104,
            105,
            106,
            107,
            108,
            109,
            110,
            111,
            112,
            113,
            114,

            155,

            157,
            158,
            159,
            160,
            161,
            162,
            163,
            164,
            165,

            169,
            170,

            196,
            197,
            198,
            199,

            202,
            203,
            204,
            205,
            206,
            207,
            208,
            209,

            231,
            232,

            252,
            253,
            254,
            255,
            256,
            257,
            258,
            259,
            260,
            261,
            262,
            263,
            264,
            265,
            266,
            267,
            268,
            269,

            383,
            384,
            385,

            575,
            576,
            577,
            578,
            579,
            580,
            581,
            582,
            583,
            584,
            585,
            586,
            587,
            588,
            589,
            590,
            591,
            592,
            593,
            594,
            595,
            596,
            597,
            598,
            599,

            660,
            661,
            662,
            663,
            664,
            665,
            666,
            667,
            668,
            669,
            670,

            756,
            757,
            758,
            759,
            760,
            761,
            762,
            763,
            764,
            765,
            766,
            767,
            768,
            769,
            770,
            771,

            808,
            809,
            810,
            811,
            812,
            813,
            814,
            815,
            816,
        ]);

        $ab = App\Finishes::create(array('name' => 'AB'));
        $ab->beads()->attach([

            14,
            15,
            16,

            19,

            38,
            39,
            40,
            41,
            42,
            43,
            44,
            45,
            46,
            47,

            50,

            58,

            62,
            63,
            64,

            69,
            70,
            71,
            72,
            73,
            74,
            75,
            76,
            77,

            80,

            83,
            84,
            85,

            87,

            89,
            90,
            91,

            102,

            105,
            106,
            107,
            108,

            112,
            113,
            114,

            123,
            124,
            125,
            126,
            127,
            128,
            129,
            130,
            131,
            132,
            133,
            134,
            135,
            136,
            137,
            138,
            139,
            140,
            141,
            142,
            143,
            144,
            145,
            146,
            147,
            148,

            156,

            173,

            215,

            233,

            236,

            240,
            241,

            251,

            261,
            262,

            265,

            269,

            323,
            324,
            325,
            326,
            327,
            328,
            329,
            330,
            331,
            332,
            333,
            334,
            335,
            336,
            337,
            338,
            339,
            340,

            381,

            391,

            509,
            510,
            511,
            512,
            513,
            514,
            515,
            516,
            517,
            518,
            519,
            520,
            521,
            522,
            523,
            524,
            525,
            526,
            527,
            528,
            529,
            530,
            531,
            532,
            533,
            534,
            535,
            536,
            537,
            538,
            539,
            540,
            541,
            542,

            574,
            575,
            576,
            577,
            578,
            579,
            580,
            581,
            582,
            583,
            584,
            585,

            588,
            589,
            590,
            591,
            592,
            593,
            594,
            595,
            596,
            597,
            598,
            599,

            671,
            672,
            673,
            674,
            675,
            676,
            677,
            678,
            679,
            680,
            681,

            693,
            694,
            695,
            696,
            697,
            698,

            781,
            782,
            783,
            784,
            785,
            786,
            787,
            788,
            789,

            799,
            800,
            801,
            802,
            803,
            804,
            805,
            806,
            807,
            808,
            809,
            810,
            811,
            812,
            813,
            814,
            815,
            816,

            827,
            828,
            829,
            830,
            831,
            832,
            833,
            834,
            835,

            845,
            846,
            847,
            848,
            849,
            850,
            851,
            852,
        ]);


        $matte = App\Finishes::create(array('name' => 'Matte'));
        $matte->beads()->attach([

            231,
            232,
            233,
            234,
            235,
            236,
            237,
            238,
            239,
            240,
            241,
            242,
            243,
            244,
            245,
            246,

            248,
            249,
            250,
            251,
            252,
            253,
            254,
            255,
            256,
            257,
            258,
            259,
            260,
            261,
            262,
            263,
            264,
            265,
            266,
            267,
            268,
            269,
            270,
            271,
            272,
            273,
            274,
            275,
            276,
            277,
            278,
            279,
            280,

            439,
            440,
            441,
            442,
            443,
            444,
            445,
            446,
            447,
            448,
            449,
            450,
            451,
            452,
            453,
            454,
            455,
            456,
            457,
            458,
            459,
            460,
            461,
            462,
            463,
            464,
            465,
            466,
            467,
            468,
            469,
            470,
            471,
            472,
            473,
            474,
            475,
            476,
            477,
            478,
            479,
            480,
            481,
            482,
            483,
            484,
            485,
            486,
            487,
            488,
            489,
            490,
            491,
            492,
            493,
            494,

            509,
            510,
            511,
            512,
            513,
            514,
            515,
            516,
            517,
            518,
            519,
            520,
            521,
            522,
            523,
            524,
            525,
            526,
            527,
            528,
            529,
            530,
            531,
            532,
            533,
            534,
            535,
            536,
            537,
            538,
            539,
            540,
            541,
            542,

            587,
            588,
            589,
            590,
            591,
            592,
            593,
            594,
            595,
            596,
            597,
            598,
            599,

            629,
            630,
            631,
            632,
            633,
            634,
            635,
            636,
            637,
            638,
            639,
            640,
            641,
            642,

            682,
            683,
            684,
            685,
            686,
            687,
            688,
            689,
            690,
            691,
            692,
            693,
            694,
            695,
            696,
            697,
            698,

            790,
            791,
            792,
            793,
            794,
            795,
            796,
            797,
            798,
            799,
            800,
            801,
            802,
            803,
            804,
            805,
            806,
            807,

            836,
            837,
            838,
            839,
            840,
            841,
            842,
            843,
            844,
            845,
            846,
            847,
            848,
            849,
            850,
            851,
            852,

            865,
            866,
            867,
            868,
            869,
            870,
            871,
            872,
            873,
            874,
            875,
            876,
            877,
            878,
            879,
        ]);


        $iris = App\Finishes::create(array('name' => 'Iris'));
        $iris->beads()->attach([

            2,
            3,
            4,

            6,
            7,

        ]);


        $ceylon = App\Finishes::create(array('name' => 'Ceylon'));
        $ceylon->beads()->attach([

            176,
            177,
            178,
            179,
            180,
            181,
            182,
            183,
            184,
            185,
            186,
            187,
            188,
            189,
            190,
            191,
            192,
            193,
            194,
            195,

            200,
            201,

            239,

            342,

            355,
            356,
            357,
            358,
            359,
            360,
            361,
            362,
            363,
            364,
            365,
        ]);


        $metallic = App\Finishes::create(array('name' => 'Metallic'));
        $metallic->beads()->attach([

            9,
            10,

            12,
            13,
            14,
            15,
            16,
            17,
            18,

            231,

            235,
            236,

            238,

            240,
            241,
            242,

            245,

            281,
            282,
            283,
            284,
            285,
            286,
            287,
            288,
            289,
            290,
            291,
            292,
            293,
            294,
            295,
            296,
            297,
            298,
            299,
            300,
            301,
            302,
            303,
            304,
            305,
            306,
            307,

            575,
            576,
            577,
            578,
            579,
            580,
            581,
            582,
            583,
            584,
            585,
            586,
            587,
            588,
            589,
            590,
            591,
            592,
            593,
            594,
            595,
            596,
            597,
            598,
            599,
        ]);
    }
}