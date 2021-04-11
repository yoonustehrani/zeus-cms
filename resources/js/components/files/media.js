import React, { Component } from 'react'
import InfiniteScroller from 'react-infinite-scroller'
import MediaItem from './media-item'

export default class Media extends Component {
    constructor(props) {
        super(props)
        this.state = {
            scroller: {
                current_page: 1,
                hasMore: true,
                data: [],
                loading: true
            }
        }
        this.scrollParentRef = React.createRef()
    }

    loadMore = () => {
        let { scroller } = this.state
        if (!scroller.loading && scroller.hasMore) {
            this.setState(prevState => ({
                scroller: {
                    ...prevState.scroller,
                    data: [...prevState, ]
                }
            }))
        }
    }

    render() {
        let { scroller } = this.state 

        return (
            <div className="col-12 remove-sm-padding scroll-parent" ref={this.scrollParentRef}>
                <div className="media-container">
                    {/* <InfiniteScroller
                        pageStart={0}
                        loadMore={this.loadMore.bind(this)}
                        hasMore={scroller.hasMore}
                        loader={<div>loading ...</div>}
                        useWindow={false}
                        getScrollParent={() => this.scrollParentRef}
                    > */}
                        {scroller.data.map((item, i) => (
                            <MediaItem />
                        ))}
                    {/* </InfiniteScroller> */}
                </div>
            </div>
        )
    }
}
