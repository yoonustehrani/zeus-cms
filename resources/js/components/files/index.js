import React, { Component } from 'react'
import Uploader from './uploader'
import FilterBox from './filter-box'
import Media from './media'

export default class ReactFiles extends Component {
    constructor(props) {
        super(props)
        this.mediaRef = React.createRef()
        this.state = {
            files: [],
            query: `${this.props.searchUrl}?type=image&order_by=name&order=asc`,
            loading: false,
        }
    }

    setNewResults = (results, query) => {
        this.setState(prevState => ({
            files: results,
            query: query ? query : prevState.query
        }))
    }

    setLoading = (value) => {
        this.setState({loading: value})
    }

    setScroller = (value) => {
        this.mediaRef.current.setScroller(value)
    }

    render() {
        let { files, query, loading, scroller } = this.state
        let { searchUrl, fileUrl, uploadUrl } = this.props

        return (
            <div>
                <div className="filterbox-uploader-container">
                    <Uploader files={files} setNewResults={this.setNewResults.bind(this)} uploadUrl={uploadUrl} />
                    <FilterBox files={files} setNewResults={this.setNewResults.bind(this)} searchUrl={searchUrl} setLoading={this.setLoading.bind(this)} setScroller={this.setScroller.bind(this)} />
                </div>
                <Media files={files} setNewResults={this.setNewResults.bind(this)} fileUrl={fileUrl} query={query} loading={loading} ref={this.mediaRef} />
            </div>
        )
    }
}
