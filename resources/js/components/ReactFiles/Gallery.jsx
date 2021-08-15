import React, { Component } from 'react';
import Axios from 'axios';
import InfiniteScroll from 'react-infinite-scroller';
import GalleryItem from './GalleryItem';
import {addFiles} from './actions'

class Gallery extends Component {
    constructor(props) {
        super(props)
        this.state = {
            hasMore: true,
            loading: false,
            currentPage: 1,
        }
    }
    loadMore = () => {
        let {files, dispatch, query} = this.props
        if (this.state.hasMore) {
            this.setState({
                loading: true
            }, () => {
                Axios.get(`${query}&page=${this.state.currentPage}`).then(res => {
                    let { data, current_page, next_page_url } = res.data
                    this.setState(prevState => ({
                        currentPage: current_page + 1,
                        hasMore: !! next_page_url,
                        loading: false
                    }), () => {
                        dispatch(addFiles(data))
                    })
                })
            })
        }
    }

    reset = () => {
        this.setState({
            hasMore: true,
            loading: false,
            currentPage: 1,
        })
    }

    render() {
        let {files, dispatch, selectedFiles} = this.props
        let {hasMore, loading } = this.state

        return (
            <div className="col-12 remove-sm-padding float-left">
                <InfiniteScroll
                className="media-container w-100"
                pageStart={0}
                loadMore={this.loadMore} // .bind(this)
                hasMore={hasMore && !loading}
                useWindow={false}
                getScrollParent={() => document.getElementsByClassName("contentbar")[0]}
                >
                {files.map((file, i) => (
                    <GalleryItem
                    key={i}
                    restoreFile={null}
                    selectFile={null}
                    deleteFile={null}
                    dispatch={dispatch}
                    selected={selectedFiles.includes(file.id)}
                    {...file} />
                ))}
                </InfiniteScroll>
                {!loading && files.length === 0 && <div className="alert alert-light mt-4 w-100 text-center">No Item to show</div>}
            </div>
        );
    }
}

export default Gallery;