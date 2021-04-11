import React, { Component } from 'react'
import Uploader from './uploader'
import FilterBox from './filter-box'
import Media from './media'

export default class ReactFiles extends Component {
    state = {
        files: []
    }

    addNewFile = (fileInfo) => {
        this.setState(prevState => {
            let newFiles = prevState.files
            newFiles.unshift(fileInfo)
            return {
                ...prevState,
                files: newFiles
            }
        })
    }

    render() {
        return (
            <div>
                <Uploader addNewFile={this.addNewFile.bind(this)} />
                <FilterBox />
                <Media />
            </div>
        )
    }
}
