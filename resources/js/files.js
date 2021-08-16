import React from 'react'
import ReactDOM from 'react-dom'
import ReactFiles from './components/ReactFiles'

const target = document.getElementById("react-files")

if (target) {
    let searchUrl = target.getAttribute("data-search"),
    fileUrl = target.getAttribute("data-file"),
    uploadUrl  = target.getAttribute("data-upload"),
    editFormUrl  = target.getAttribute("data-edit"),
    restoreUrl = target.getAttribute("data-restore");

    ReactDOM.render(
        <ReactFiles editFormUrl={editFormUrl} searchUrl={searchUrl} fileUrl={fileUrl} uploadUrl={uploadUrl} restoreUrl={restoreUrl}/>
    , target)
}
