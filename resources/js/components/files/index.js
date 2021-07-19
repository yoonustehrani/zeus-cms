import React, { Component } from 'react'
import Uploader from './uploader'
import FilterBox from './filter-box'
import Media from './media'

export default class ReactFiles extends Component {
    constructor(props) {
        super(props)
        this.state = {
            files: [],
            query: `${this.props.searchUrl}?type=image&order_by=name&order=asc`
        }
    }

    setNewResults = (results, query) => {
        this.setState(prevState => ({
            files: results,
            query: query ? query : prevState.query
        }))
    }

    render() {
        let { files, query } = this.state
        let { searchUrl, fileUrl, uploadUrl } = this.props

        return (
            <div>
                <div className="filterbox-uploader-container">
                    <Uploader files={files} setNewResults={this.setNewResults.bind(this)} uploadUrl={uploadUrl} />
                    <FilterBox files={files} setNewResults={this.setNewResults.bind(this)} searchUrl={searchUrl} />
                </div>
                <Media files={files} setNewResults={this.setNewResults.bind(this)} fileUrl={fileUrl} query={query} />
            </div>
        )
    }
}
