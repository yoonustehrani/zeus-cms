import React, { Component } from 'react'
import InfiniteScroller from 'react-infinite-scroller'
import MediaItem from './media-item'
import Axios from 'axios'

export default class Media extends Component {
    constructor(props) {
        super(props)
        this.state = {
            scroller: {
                current_page: 1,
                hasMore: true,
                data: [],
                loading: false
            }
        }
    }

    loadMore = () => {
        let { scroller } = this.state
        let { query, setNewResults } = this.props
        if (scroller.hasMore) {
            this.setState({
                scroller: {
                    ...scroller,
                    loading: true
                }
            }, () => {
                Axios.get(`${query}&page=${scroller.current_page}`).then(res => {
                    let { data, current_page, last_page } = res.data
                    this.setState(prevState => ({
                        scroller: {
                            current_page: prevState.scroller.current_page++,
                            hasMore: current_page !== last_page,
                            data: [...prevState.scroller.data, ...data],
                            loading: false
                        }
                    }), () => {
                        setNewResults(this.state.scroller.data)
                    })
                })
            })
        }
    }

    render() {
        let { scroller } = this.state 
        let { files, fileUrl } = this.props

        return (
            <div className="col-12 remove-sm-padding float-left">
                <div className="media-container">
                        <InfiniteScroller
                            pageStart={0}
                            loadMore={this.loadMore.bind(this)}
                            hasMore={scroller.hasMore && !scroller.loading}
                            loader={<div key={0}>loading ...</div>}
                            useWindow={false}
                            getScrollParent={() => document.getElementsByClassName("contentbar")[0]}
                        >
                            {files.map((item, i) => (
                                <MediaItem key={i} {...item} />
                            ))}
                        </InfiniteScroller>
                    {!scroller.loading && files.length < 0 && <div className="alert alert-light mt-4 w-100 text-center">No Item to show</div>}
                </div>
            </div>
        )
    }
}
