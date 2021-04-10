import React from 'react'
import ReactDOM from 'react-dom'
import ReactFiles from './components/files'


const target = document.getElementById("react-files")

if (target) {
    ReactDOM.render(
        <ReactFiles/>
    , target)
}
