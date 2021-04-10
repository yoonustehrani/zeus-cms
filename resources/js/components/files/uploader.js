import React, { Component } from 'react'
import Dropzone from "dropzone"

export default class Uploader extends Component {
    componentDidMount() {
        //dropzone
        Dropzone.autoDiscover = false
        let myDropzone = new Dropzone("#dropzoneTarget", {
            createImageThumbnails: true,
            clickable: true,
            acceptedFiles: ".jpeg, .jpg, .png, .svg, .gif",
            addRemoveLinks: true,
        })
        myDropzone.on("success", response => {
            // here  we will add the uploaded file to the server
        })
        this.props.addNewFile("hello this is a test")
    }
    
    render() {
        return (
            <div className="col-md-8 float-right">
                <form action="/" id="dropzoneTarget" className="dropzone"></form>
            </div>
        )
    }
}
