import React, { Component } from 'react'
import InfiniteScroller from 'react-infinite-scroller'
import MediaItem from './media-item'
import Axios from 'axios'
import 'react-activity/lib/Spinner/Spinner.css'
import { Spinner } from 'react-activity'

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
                            current_page: current_page + 1,
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

    deleteFile = (fileId, softDeleted) => {
        let {setNewResults, files} = this.props;
        let path = this.props.fileUrl.replace('fileId', fileId) + `?force_delete=${softDeleted ? 'true' : ''}`;
        Axios.delete(path).then(res => {
            if (res.data.okay) {
                this.setState(prevState => ({
                    scroller: {
                        data: files.filter(x => x.id !== fileId)
                    }
                }), () => {
                    setNewResults(this.state.scroller.data)
                })
            }
        })
    }

    render() {
        let { scroller } = this.state 
        let { files, loading } = this.props
        return (
            <div className="col-12 remove-sm-padding float-left">
                {!loading &&
                    <InfiniteScroller
                    pageStart={0}
                    loadMore={this.loadMore.bind(this)}
                    hasMore={scroller.hasMore && !scroller.loading}
                    useWindow={false}
                    getScrollParent={() => document.getElementsByClassName("contentbar")[0]}
                    className="media-container"
                    >
                        {files.map((file, i) => (
                            <MediaItem key={i} deleteFile={this.deleteFile.bind(this)} {...file} />
                        ))}
                    </InfiniteScroller>
                }
                {!scroller.loading && !loading && files.length === 0 && <div className="alert alert-light mt-4 w-100 text-center">No Item to show</div>}
                {(scroller.loading || loading) && <div className="w-100 text-center mt-4"><Spinner color="#000000" size={30} /></div>}
            </div>
        )
    }
}
