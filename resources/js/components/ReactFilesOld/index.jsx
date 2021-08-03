import React, { Component } from 'react'
import Uploader from './uploader'
import ActionBox from './ActionBox'
import Gallery from './Gallery'

export default class ReactFiles extends Component {
    constructor(props) {
        super(props)
        this.mediaRef = React.createRef()
        this.state = {
            files: [],
            query: `${this.props.searchUrl}?type=image&order_by=name&order=asc`,
            loading: false,
            filters: {
                sort_by: "name",
                file_type: "image",
                format: "all",
                order: "asc",
                trash: false,
                available_formats: {
                    image: ["jpeg", "jpg", "png", "svg", "gif"],
                    video: ["mp4", "mov", "wmv", "flv", "avi", "mkv"],
                    audio: ["mp3", "pcm", "wav", "aiff", "aac", "ogg", "wma", "falc"]
                }
            },
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

    dispatch = (obejct) => {
        
    }

    render() {
        let { files, query, loading, scroller, filters } = this.state
        let { searchUrl, fileUrl, uploadUrl } = this.props

        return (
            <div>
                <div className="filterbox-uploader-container">
                    <Uploader files={files} setNewResults={this.setNewResults.bind(this)} uploadUrl={uploadUrl} />
                    <ActionBox files={files} filterList={filters} 
                    setNewResults={this.setNewResults.bind(this)} 
                    searchUrl={searchUrl} setLoading={this.setLoading.bind(this)} 
                    setScroller={this.setScroller.bind(this)} dispatch={this.dispatch.bind(this)}/>
                </div>
                <Gallery files={files} setNewResults={this.setNewResults.bind(this)} fileUrl={fileUrl} query={query} loading={loading} ref={this.mediaRef} />
            </div>
        )
    }
}
