import React, { Component } from 'react'
import Dropzone from "dropzone"
import {addFile} from './actions'

export default class Uploader extends Component {
    componentDidMount() {
        let {dispatch, uploadUrl} = this.props;
        let token = document.head.querySelector('meta[name="csrf-token"]')
        Dropzone.autoDiscover = false
        let myDropzone = new Dropzone("#dropzoneTarget", {
            url: uploadUrl,
            createImageThumbnails: true,
            clickable: true,
            acceptedFiles: ".jpeg, .jpg, .png, .svg, .gif",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': token.content,
                'Accept': 'application/json'
            }
        })
        myDropzone.on("success", (dropzone, res) => dispatch(addFile(res, false)))
    }
    
    render() {
        return (
            <div className="col-lg-8 float-right remove-sm-padding uploader-container">
                <form id="dropzoneTarget" className="dropzone"></form>
            </div>
        )
    }
}
