import React, { Component } from 'react'
import InfiniteScroller from 'react-infinite-scroller'
import Item from './Item'
import Axios from 'axios'
import 'react-activity/lib/Spinner/Spinner.css'
import { Spinner } from 'react-activity'
import Actions from './Actions'

export default class Gallery extends Component {
    constructor(props) {
        super(props)
        this.state = {
            selectedItems: [],
            bulkActions: [
                {
                    title: 'Move to trash',
                    icon: 'fas fa-trash',
                    action: this.deleteFilesBulk,
                },
                {
                    title: 'Restore',
                    icon: 'fas fa-reset',
                    action: this.restore
                }
            ],
            scroller: {
                current_page: 1,
                hasMore: true,
                data: [],
                loading: false
            }
        }
    }

    setScroller = (value) => {
        this.setState({
            scroller: value
        })
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
                    this.setState(prevState => {
                        return ({
                        scroller: {
                            current_page: current_page + 1,
                            hasMore: current_page !== last_page,
                            data: [...prevState.scroller.data, ...data],
                            loading: false
                        }
                    })}, () => {
                        setNewResults(this.state.scroller.data)
                    })
                })
            })
        }
    }

    deleteFile = (fileId, softDeleted) => {
        let {setNewResults, files, fileUrl} = this.props;
        let path = fileUrl.replace('fileId', fileId) + `?force_delete=${softDeleted ? 'true' : ''}`;
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

    deleteFilesBulk = () => {
        let {selectedItems} = this.state;
        let {setNewResults, files} = this.props;
        if (selectedItems.length > 1) {
            let id_request = selectedItems.join(',');
            let path = this.props.fileUrl.replace('fileId', id_request); // + `?force_delete=${softDeleted ? 'true' : ''}`
            Axios.delete(path).then(res => {
                let deleted = [];
                Object.entries(res.data).map(file => {
                    deleted.push(Number(file[0]))
                });
                this.setState(prevState => ({
                    scroller: {
                        data: files.filter(x => ! deleted.includes(x.id))
                    }
                }), () => {
                    setNewResults(this.state.scroller.data)
                })
            })
        } else {
            let {id , deleted_at} = this.state.scroller.data.filter(file => file.id === selectedItems[0])[0];
            this.deleteFile(id, Boolean(deleted_at))
        }
        this.setState({ selectedItems: []})
    }

    restore = (fileId) => {
        let {selectedItems} = this.state;
        let {setNewResults, files} = this.props;
        console.log(fileId);
    }

    selectFile = (fileId, unselect = false) => {
        if (unselect) {
            this.setState(prevState => ({
                selectedItems: prevState.selectedItems.filter(x => x !== fileId)
            }));
            return;
        }
        this.setState(prevState => ({
            selectedItems: [...prevState.selectedItems, fileId]
        }));
    }

    render() {
        let { scroller, bulkActions, selectedItems } = this.state 
        let { files, loading } = this.props
        return (
            <div className="col-12 remove-sm-padding float-left">
                <Actions selectedItems={selectedItems} bulkActions={bulkActions}/>
                {!loading &&
                    <InfiniteScroller
                    pageStart={0}
                    loadMore={this.loadMore.bind(this)}
                    hasMore={scroller.hasMore && !scroller.loading}
                    useWindow={false}
                    getScrollParent={() => document.getElementsByClassName("contentbar")[0]}
                    className="media-container w-100"
                    >
                        {files.map((file, i) => (
                            <Item 
                            key={i}
                            restoreFile={this.restore.bind(this)}
                            selectFile={this.selectFile.bind(this)}
                            deleteFile={this.deleteFile.bind(this)}
                            selected={this.state.selectedItems.includes(file.id)}
                            {...file} />
                        ))}
                    </InfiniteScroller>
                }
                {!scroller.loading && !loading && files.length === 0 && <div className="alert alert-light mt-4 w-100 text-center">No Item to show</div>}
                {(scroller.loading || loading) && <div className="w-100 text-center mt-4"><Spinner color="#000000" size={30} /></div>}
            </div>
        )
    }
}