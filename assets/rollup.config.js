import buble from '@rollup/plugin-buble'
import {terser} from 'rollup-plugin-terser'

export default [{
    input: 'src/index.js',
    output: {
        file: '../dist/mukadi.chart.js',
        format: 'iife',
        name: 'mukadiChart'
    },
    plugins: [
        buble()
    ]
},{
    input: 'src/index.js',
    output: {
        file: '../dist/mukadi.chart.min.js',
        format: 'iife',
        name: 'mukadiChart'
    },
    plugins: [
        buble(),
        terser()
    ]
}];