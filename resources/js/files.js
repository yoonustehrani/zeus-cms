import React from 'react'
import ReactDOM from 'react-dom'
import ReactFiles from './components/files'


const target = document.getElementById("react-files")

if (target) {
    let searchUrl = target.getAttribute("search-url")
    let fileUrl = target.getAttribute("file-url") 

    ReactDOM.render(
        <ReactFiles
            searchUrl = {searchUrl}
            fileUrl = {fileUrl}
        />
    , target)
}
