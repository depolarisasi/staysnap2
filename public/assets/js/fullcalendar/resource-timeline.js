/*!
FullCalendar Resource Timeline Plugin v6.1.8
Docs & License: https://fullcalendar.io/docs/timeline-view
(c) 2023 Adam Shaw
*/
FullCalendar.ResourceTimeline=function(e,t,r,o,n,l,s,i,a,d){"use strict";function c(e){return e&&e.__esModule?e:{default:e}}var u=c(r),h=c(o),p=c(n);function m({depth:e,hasChildren:t,isExpanded:r,onExpanderClick:o}){let n=[];for(let t=0;t<e;t+=1)n.push(s.createElement("span",{className:"fc-icon"}));let l=["fc-icon"];return t&&(r?l.push("fc-icon-minus-square"):l.push("fc-icon-plus-square")),n.push(s.createElement("span",{className:"fc-datagrid-expander"+(t?"":" fc-datagrid-expander-placeholder"),onClick:o},s.createElement("span",{className:l.join(" ")}))),s.createElement(s.Fragment,{},...n)}class f extends l.BaseComponent{constructor(){super(...arguments),this.refineRenderProps=l.memoizeObjArg(C),this.onExpanderClick=e=>{let{props:t}=this;t.hasChildren&&this.context.dispatch({type:"SET_RESOURCE_ENTITY_EXPANDED",id:t.resource.id,isExpanded:!t.isExpanded})}}render(){let{props:e,context:t}=this,{colSpec:r}=e,o=this.refineRenderProps({resource:e.resource,fieldValue:e.fieldValue,context:t});return s.createElement(l.ContentContainer,{elTag:"td",elClasses:["fc-datagrid-cell","fc-resource"],elAttrs:{role:"gridcell","data-resource-id":e.resource.id},renderProps:o,generatorName:r.isMain?"resourceLabelContent":void 0,customGenerator:r.cellContent,defaultGenerator:g,classNameGenerator:r.cellClassNames,didMount:r.cellDidMount,willUnmount:r.cellWillUnmount},t=>s.createElement("div",{className:"fc-datagrid-cell-frame",style:{height:e.innerHeight}},s.createElement("div",{className:"fc-datagrid-cell-cushion fc-scrollgrid-sync-inner"},r.isMain&&s.createElement(m,{depth:e.depth,hasChildren:e.hasChildren,isExpanded:e.isExpanded,onExpanderClick:this.onExpanderClick}),s.createElement(t,{elTag:"span",elClasses:["fc-datagrid-cell-main"]}))))}}function g(e){return e.fieldValue||s.createElement(s.Fragment,null," ")}function C(e){return{resource:new n.ResourceApi(e.context,e.resource),fieldValue:e.fieldValue,view:e.context.viewApi}}class R extends l.BaseComponent{render(){let{props:e,context:t}=this,{colSpec:r}=e,o={groupValue:e.fieldValue,view:t.viewApi};return s.createElement(l.ContentContainer,{elTag:"td",elClasses:["fc-datagrid-cell","fc-resource-group"],elAttrs:{role:"gridcell",rowSpan:e.rowSpan},renderProps:o,generatorName:"resourceGroupLabelContent",customGenerator:r.cellContent,defaultGenerator:w,classNameGenerator:r.cellClassNames,didMount:r.cellDidMount,willUnmount:r.cellWillUnmount},e=>s.createElement("div",{className:"fc-datagrid-cell-frame fc-datagrid-cell-frame-liquid"},s.createElement(e,{elTag:"div",elClasses:["fc-datagrid-cell-cushion","fc-sticky"]})))}}function w(e){return e.groupValue||s.createElement(s.Fragment,null," ")}class E extends l.BaseComponent{render(){let{props:e}=this,{resource:t,rowSpans:r,depth:o}=e,n=a.buildResourceFields(t);return s.createElement("tr",{role:"row"},e.colSpecs.map((l,i)=>{let d=r[i];if(0===d)return null;null==d&&(d=1);let c=l.field?n[l.field]:t.title||a.getPublicId(t.id);return d>1?s.createElement(R,{key:i,colSpec:l,fieldValue:c,rowSpan:d}):s.createElement(f,{key:i,colSpec:l,resource:t,fieldValue:c,depth:o,hasChildren:e.hasChildren,isExpanded:e.isExpanded,innerHeight:e.innerHeight})}))}}E.addPropsEquality({rowSpans:l.isArraysEqual});class S extends l.BaseComponent{constructor(){super(...arguments),this.innerInnerRef=s.createRef(),this.onExpanderClick=()=>{let{props:e}=this;this.context.dispatch({type:"SET_RESOURCE_ENTITY_EXPANDED",id:e.id,isExpanded:!e.isExpanded})}}render(){let{props:e,context:t}=this,r={groupValue:e.group.value,view:t.viewApi},o=e.group.spec;return s.createElement("tr",{role:"row"},s.createElement(l.ContentContainer,{elTag:"th",elClasses:["fc-datagrid-cell","fc-resource-group",t.theme.getClass("tableCellShaded")],elAttrs:{role:"columnheader",scope:"colgroup",colSpan:e.spreadsheetColCnt},renderProps:r,generatorName:"resourceGroupLabelContent",customGenerator:o.labelContent,defaultGenerator:y,classNameGenerator:o.labelClassNames,didMount:o.labelDidMount,willUnmount:o.labelWillUnmount},t=>s.createElement("div",{className:"fc-datagrid-cell-frame",style:{height:e.innerHeight}},s.createElement("div",{className:"fc-datagrid-cell-cushion fc-scrollgrid-sync-inner",ref:this.innerInnerRef},s.createElement(m,{depth:0,hasChildren:!0,isExpanded:e.isExpanded,onExpanderClick:this.onExpanderClick}),s.createElement(t,{elTag:"span",elClasses:["fc-datagrid-cell-main"]})))))}}function y(e){return e.groupValue||s.createElement(s.Fragment,null," ")}S.addPropsEquality({group:a.isGroupsEqual});class b extends l.BaseComponent{constructor(){super(...arguments),this.resizerElRefs=new l.RefMap(this._handleColResizerEl.bind(this)),this.colDraggings={}}render(){let{colSpecs:e,superHeaderRendering:t,rowInnerHeights:r}=this.props,o={view:this.context.viewApi},n=[];if(r=r.slice(),t){let i=r.shift();n.push(s.createElement("tr",{key:"row-super",role:"row"},s.createElement(l.ContentContainer,{elTag:"th",elClasses:["fc-datagrid-cell","fc-datagrid-cell-super"],elAttrs:{role:"columnheader",scope:"colgroup",colSpan:e.length},renderProps:o,generatorName:"resourceAreaHeaderContent",customGenerator:t.headerContent,defaultGenerator:t.headerDefault,classNameGenerator:t.headerClassNames,didMount:t.headerDidMount,willUnmount:t.headerWillUnmount},e=>s.createElement("div",{className:"fc-datagrid-cell-frame",style:{height:i}},s.createElement(e,{elTag:"div",elClasses:["fc-datagrid-cell-cushion","fc-scrollgrid-sync-inner"]})))))}let i=r.shift();return n.push(s.createElement("tr",{key:"row",role:"row"},e.map((t,r)=>{let n=r===e.length-1;return s.createElement(l.ContentContainer,{key:r,elTag:"th",elClasses:["fc-datagrid-cell"],elAttrs:{role:"columnheader"},renderProps:o,generatorName:"resourceAreaHeaderContent",customGenerator:t.headerContent,defaultGenerator:t.headerDefault,classNameGenerator:t.headerClassNames,didMount:t.headerDidMount,willUnmount:t.headerWillUnmount},e=>s.createElement("div",{className:"fc-datagrid-cell-frame",style:{height:i}},s.createElement("div",{className:"fc-datagrid-cell-cushion fc-scrollgrid-sync-inner"},t.isMain&&s.createElement("span",{className:"fc-datagrid-expander fc-datagrid-expander-placeholder"},s.createElement("span",{className:"fc-icon"})),s.createElement(e,{elTag:"span",elClasses:["fc-datagrid-cell-main"]})),!n&&s.createElement("div",{className:"fc-datagrid-cell-resizer",ref:this.resizerElRefs.createRef(r)})))}))),s.createElement(s.Fragment,null,n)}_handleColResizerEl(e,t){let{colDraggings:r}=this;if(e){let o=this.initColResizing(e,parseInt(t,10));o&&(r[t]=o)}else{let e=r[t];e&&(e.destroy(),delete r[t])}}initColResizing(e,t){let{pluginHooks:r,isRtl:o}=this.context,{onColWidthChange:n}=this.props,s=r.elementDraggingImpl;if(s){let r,i,a=new s(e);return a.emitter.on("dragstart",()=>{let o=l.findElements(l.elementClosest(e,"tr"),"th");i=o.map(e=>e.getBoundingClientRect().width),r=i[t]}),a.emitter.on("dragmove",e=>{i[t]=Math.max(r+e.deltaX*(o?-1:1),20),n&&n(i.slice())}),a.setAutoScrollEnabled(!1),a}return null}}class x extends l.BaseComponent{constructor(){super(...arguments),this.refineRenderProps=l.memoizeObjArg(a.refineRenderProps),this.handleHeightChange=(e,t)=>{this.props.onHeightChange&&this.props.onHeightChange(l.elementClosest(e,"tr"),t)}}render(){let{props:e,context:t}=this,{options:r}=t,o=this.refineRenderProps({resource:e.resource,context:t});return s.createElement("tr",{ref:e.elRef},s.createElement(l.ContentContainer,{elTag:"td",elClasses:["fc-timeline-lane","fc-resource"],elAttrs:{"data-resource-id":e.resource.id},renderProps:o,generatorName:"resourceLaneContent",customGenerator:r.resourceLaneContent,classNameGenerator:r.resourceLaneClassNames,didMount:r.resourceLaneDidMount,willUnmount:r.resourceLaneWillUnmount},t=>s.createElement("div",{className:"fc-timeline-lane-frame",style:{height:e.innerHeight}},s.createElement(t,{elTag:"div",elClasses:["fc-timeline-lane-misc"]}),s.createElement(i.TimelineLane,{dateProfile:e.dateProfile,tDateProfile:e.tDateProfile,nowDate:e.nowDate,todayRange:e.todayRange,nextDayThreshold:e.nextDayThreshold,businessHours:e.businessHours,eventStore:e.eventStore,eventUiBases:e.eventUiBases,dateSelection:e.dateSelection,eventSelection:e.eventSelection,eventDrag:e.eventDrag,eventResize:e.eventResize,timelineCoords:e.timelineCoords,onHeightChange:this.handleHeightChange,resourceId:e.resource.id}))))}}class H extends l.BaseComponent{render(){let{props:e,context:t}=this,{renderHooks:r}=e,o={groupValue:e.groupValue,view:t.viewApi};return s.createElement("tr",{ref:e.elRef},s.createElement(l.ContentContainer,{elTag:"td",elRef:e.elRef,elClasses:["fc-timeline-lane","fc-resource-group",t.theme.getClass("tableCellShaded")],renderProps:o,generatorName:"resourceGroupLaneContent",customGenerator:r.laneContent,classNameGenerator:r.laneClassNames,didMount:r.laneDidMount,willUnmount:r.laneWillUnmount},t=>s.createElement(t,{elTag:"div",elStyle:{height:e.innerHeight}})))}}class N extends l.BaseComponent{render(){let{props:e,context:t}=this,{rowElRefs:r,innerHeights:o}=e;return s.createElement("tbody",null,e.rowNodes.map((n,l)=>{if(n.group)return s.createElement(H,{key:n.id,elRef:r.createRef(n.id),groupValue:n.group.value,renderHooks:n.group.spec,innerHeight:o[l]||""});if(n.resource){let i=n.resource;return s.createElement(x,Object.assign({key:n.id,elRef:r.createRef(n.id)},e.splitProps[i.id],{resource:i,dateProfile:e.dateProfile,tDateProfile:e.tDateProfile,nowDate:e.nowDate,todayRange:e.todayRange,nextDayThreshold:t.options.nextDayThreshold,businessHours:i.businessHours||e.fallbackBusinessHours,innerHeight:o[l]||"",timelineCoords:e.slatCoords,onHeightChange:e.onRowHeightChange}))}return null}))}}class v extends l.BaseComponent{constructor(){super(...arguments),this.rootElRef=s.createRef(),this.rowElRefs=new l.RefMap}render(){let{props:e,context:t}=this;return s.createElement("table",{ref:this.rootElRef,"aria-hidden":!0,className:"fc-scrollgrid-sync-table "+t.theme.getClass("table"),style:{minWidth:e.tableMinWidth,width:e.clientWidth,height:e.minHeight}},s.createElement(N,{rowElRefs:this.rowElRefs,rowNodes:e.rowNodes,dateProfile:e.dateProfile,tDateProfile:e.tDateProfile,nowDate:e.nowDate,todayRange:e.todayRange,splitProps:e.splitProps,fallbackBusinessHours:e.fallbackBusinessHours,slatCoords:e.slatCoords,innerHeights:e.innerHeights,onRowHeightChange:e.onRowHeightChange}))}componentDidMount(){this.updateCoords()}componentDidUpdate(){this.updateCoords()}componentWillUnmount(){this.props.onRowCoords&&this.props.onRowCoords(null)}updateCoords(){let{props:e}=this;var t;e.onRowCoords&&null!==e.clientWidth&&this.props.onRowCoords(new l.PositionCache(this.rootElRef.current,(t=this.rowElRefs.currentMap,e.rowNodes.map(e=>t[e.id])),!1,!0))}}class D extends l.DateComponent{constructor(){super(...arguments),this.computeHasResourceBusinessHours=l.memoize(P),this.resourceSplitter=new a.ResourceSplitter,this.bgSlicer=new i.TimelineLaneSlicer,this.slatsRef=s.createRef(),this.state={slatCoords:null},this.handleEl=e=>{e?this.context.registerInteractiveComponent(this,{el:e}):this.context.unregisterInteractiveComponent(this)},this.handleSlatCoords=e=>{this.setState({slatCoords:e}),this.props.onSlatCoords&&this.props.onSlatCoords(e)},this.handleRowCoords=e=>{this.rowCoords=e,this.props.onRowCoords&&this.props.onRowCoords(e)}}render(){let{props:e,state:t,context:r}=this,{dateProfile:o,tDateProfile:n}=e,a=l.greatestDurationDenominator(n.slotDuration).unit,d=this.computeHasResourceBusinessHours(e.rowNodes),c=this.resourceSplitter.splitProps(e),u=c[""],h=this.bgSlicer.sliceProps(u,o,n.isTimeScale?null:e.nextDayThreshold,r,o,r.dateProfileGenerator,n,r.dateEnv),p=t.slatCoords&&t.slatCoords.dateProfile===e.dateProfile?t.slatCoords:null;return s.createElement("div",{ref:this.handleEl,className:["fc-timeline-body",e.expandRows?"fc-timeline-body-expandrows":""].join(" "),style:{minWidth:e.tableMinWidth}},s.createElement(l.NowTimer,{unit:a},(t,a)=>s.createElement(s.Fragment,null,s.createElement(i.TimelineSlats,{ref:this.slatsRef,dateProfile:o,tDateProfile:n,nowDate:t,todayRange:a,clientWidth:e.clientWidth,tableColGroupNode:e.tableColGroupNode,tableMinWidth:e.tableMinWidth,onCoords:this.handleSlatCoords,onScrollLeftRequest:e.onScrollLeftRequest}),s.createElement(i.TimelineLaneBg,{businessHourSegs:d?null:h.businessHourSegs,bgEventSegs:h.bgEventSegs,timelineCoords:p,eventResizeSegs:h.eventResize?h.eventResize.segs:[],dateSelectionSegs:h.dateSelectionSegs,nowDate:t,todayRange:a}),s.createElement(v,{rowNodes:e.rowNodes,dateProfile:o,tDateProfile:e.tDateProfile,nowDate:t,todayRange:a,splitProps:c,fallbackBusinessHours:d?e.businessHours:null,clientWidth:e.clientWidth,minHeight:e.expandRows?e.clientHeight:"",tableMinWidth:e.tableMinWidth,innerHeights:e.rowInnerHeights,slatCoords:p,onRowCoords:this.handleRowCoords,onRowHeightChange:e.onRowHeightChange}),r.options.nowIndicator&&p&&p.isDateInRange(t)&&s.createElement("div",{className:"fc-timeline-now-indicator-container"},s.createElement(l.NowIndicatorContainer,{elClasses:["fc-timeline-now-indicator-line"],elStyle:i.coordToCss(p.dateToCoord(t),r.isRtl),isAxis:!1,date:t})))))}queryHit(e,t){let r=this.rowCoords,o=r.topToIndex(t);if(null!=o){let t=this.props.rowNodes[o].resource;if(t){let n=this.slatsRef.current.positionToHit(e);if(n)return{dateProfile:this.props.dateProfile,dateSpan:{range:n.dateSpan.range,allDay:n.dateSpan.allDay,resourceId:t.id},rect:{left:n.left,right:n.right,top:r.tops[o],bottom:r.bottoms[o]},dayEl:n.dayEl,layer:0}}}return null}}function P(e){for(let t of e){let e=t.resource;if(e&&e.businessHours)return!0}return!1}class W extends l.BaseComponent{constructor(){super(...arguments),this.scrollGridRef=s.createRef(),this.timeBodyScrollerElRef=s.createRef(),this.spreadsheetHeaderChunkElRef=s.createRef(),this.rootElRef=s.createRef(),this.ensureScrollGridResizeId=0,this.state={resourceAreaWidthOverride:null},this.ensureScrollGridResize=()=>{this.ensureScrollGridResizeId&&clearTimeout(this.ensureScrollGridResizeId),this.ensureScrollGridResizeId=setTimeout(()=>{this.scrollGridRef.current.handleSizing(!1)},l.config.SCROLLGRID_RESIZE_INTERVAL+1)}}render(){let{props:e,state:t,context:r}=this,{options:o}=r,n=!e.forPrint&&l.getStickyHeaderDates(o),i=!e.forPrint&&l.getStickyFooterScrollbar(o),a=[{type:"header",key:"header",syncRowHeights:!0,isSticky:n,chunks:[{key:"datagrid",elRef:this.spreadsheetHeaderChunkElRef,tableClassName:"fc-datagrid-header",rowContent:e.spreadsheetHeaderRows},{key:"divider",outerContent:s.createElement("td",{role:"presentation",className:"fc-resource-timeline-divider "+r.theme.getClass("tableCellShaded")})},{key:"timeline",content:e.timeHeaderContent}]},{type:"body",key:"body",syncRowHeights:!0,liquid:!0,expandRows:Boolean(o.expandRows),chunks:[{key:"datagrid",tableClassName:"fc-datagrid-body",rowContent:e.spreadsheetBodyRows},{key:"divider",outerContent:s.createElement("td",{role:"presentation",className:"fc-resource-timeline-divider "+r.theme.getClass("tableCellShaded")})},{key:"timeline",scrollerElRef:this.timeBodyScrollerElRef,content:e.timeBodyContent}]}];i&&a.push({type:"footer",key:"footer",isSticky:!0,chunks:[{key:"datagrid",content:l.renderScrollShim},{key:"divider",outerContent:s.createElement("td",{role:"presentation",className:"fc-resource-timeline-divider "+r.theme.getClass("tableCellShaded")})},{key:"timeline",content:l.renderScrollShim}]});let c=null!=t.resourceAreaWidthOverride?t.resourceAreaWidthOverride:o.resourceAreaWidth;return s.createElement(d.ScrollGrid,{ref:this.scrollGridRef,elRef:this.rootElRef,liquid:!e.isHeightAuto&&!e.forPrint,forPrint:e.forPrint,collapsibleWidth:!1,colGroups:[{cols:e.spreadsheetCols,width:c},{cols:[]},{cols:e.timeCols}],sections:a})}forceTimeScroll(e){this.scrollGridRef.current.forceScrollLeft(2,e)}forceResourceScroll(e){this.scrollGridRef.current.forceScrollTop(1,e)}getResourceScroll(){return this.timeBodyScrollerElRef.current.scrollTop}componentDidMount(){this.initSpreadsheetResizing()}componentWillUnmount(){this.destroySpreadsheetResizing()}initSpreadsheetResizing(){let{isRtl:e,pluginHooks:t}=this.context,r=t.elementDraggingImpl,o=this.spreadsheetHeaderChunkElRef.current;if(r){let t,n,l=this.rootElRef.current,s=this.spreadsheetResizerDragging=new r(l,".fc-resource-timeline-divider");s.emitter.on("dragstart",()=>{t=o.getBoundingClientRect().width,n=l.getBoundingClientRect().width}),s.emitter.on("dragmove",r=>{let o=t+r.deltaX*(e?-1:1);o=Math.max(o,30),o=Math.min(o,n-30),this.setState({resourceAreaWidthOverride:o},this.ensureScrollGridResize)}),s.setAutoScrollEnabled(!1)}}destroySpreadsheetResizing(){this.spreadsheetResizerDragging&&this.spreadsheetResizerDragging.destroy()}}class M extends l.BaseComponent{constructor(e,t){super(e,t),this.processColOptions=l.memoize(A),this.buildTimelineDateProfile=l.memoize(i.buildTimelineDateProfile),this.hasNesting=l.memoize(k),this.buildRowNodes=l.memoize(a.buildRowNodes),this.layoutRef=s.createRef(),this.rowNodes=[],this.renderedRowNodes=[],this.buildRowIndex=l.memoize(T),this.handleSlatCoords=e=>{this.setState({slatCoords:e})},this.handleRowCoords=e=>{this.rowCoords=e,this.scrollResponder.update(!1)},this.handleMaxCushionWidth=e=>{this.setState({slotCushionMaxWidth:Math.ceil(e)})},this.handleScrollLeftRequest=e=>{this.layoutRef.current.forceTimeScroll(e)},this.handleScrollRequest=e=>{let{rowCoords:t}=this,r=this.layoutRef.current,o=e.rowId||e.resourceId;if(t){if(o){let n=this.buildRowIndex(this.renderedRowNodes)[o];if(null!=n){let o=null!=e.fromBottom?t.bottoms[n]-e.fromBottom:t.tops[n];r.forceResourceScroll(o)}}return!0}return null},this.handleColWidthChange=e=>{this.setState({spreadsheetColWidths:e})},this.state={resourceAreaWidth:t.options.resourceAreaWidth,spreadsheetColWidths:[]}}render(){let{props:e,state:t,context:r}=this,{options:o,viewSpec:n}=r,{superHeaderRendering:a,groupSpecs:d,orderSpecs:c,isVGrouping:u,colSpecs:h}=this.processColOptions(r.options),p=this.buildTimelineDateProfile(e.dateProfile,r.dateEnv,o,r.dateProfileGenerator),m=this.rowNodes=this.buildRowNodes(e.resourceStore,d,c,u,e.resourceEntityExpansions,o.resourcesInitiallyExpanded),{slotMinWidth:f}=o,g=i.buildSlatCols(p,f||this.computeFallbackSlotMinWidth(p));return s.createElement(l.ViewContainer,{elClasses:["fc-resource-timeline",!this.hasNesting(m)&&"fc-resource-timeline-flat","fc-timeline",!1===o.eventOverlap?"fc-timeline-overlap-disabled":"fc-timeline-overlap-enabled"],viewSpec:n},s.createElement(W,{ref:this.layoutRef,forPrint:e.forPrint,isHeightAuto:e.isHeightAuto,spreadsheetCols:G(h,t.spreadsheetColWidths,""),spreadsheetHeaderRows:e=>s.createElement(b,{superHeaderRendering:a,colSpecs:h,onColWidthChange:this.handleColWidthChange,rowInnerHeights:e.rowSyncHeights}),spreadsheetBodyRows:e=>s.createElement(s.Fragment,null,this.renderSpreadsheetRows(m,h,e.rowSyncHeights)),timeCols:g,timeHeaderContent:r=>s.createElement(i.TimelineHeader,{clientWidth:r.clientWidth,clientHeight:r.clientHeight,tableMinWidth:r.tableMinWidth,tableColGroupNode:r.tableColGroupNode,dateProfile:e.dateProfile,tDateProfile:p,slatCoords:t.slatCoords,rowInnerHeights:r.rowSyncHeights,onMaxCushionWidth:f?null:this.handleMaxCushionWidth}),timeBodyContent:t=>s.createElement(D,{dateProfile:e.dateProfile,clientWidth:t.clientWidth,clientHeight:t.clientHeight,tableMinWidth:t.tableMinWidth,tableColGroupNode:t.tableColGroupNode,expandRows:t.expandRows,tDateProfile:p,rowNodes:m,businessHours:e.businessHours,dateSelection:e.dateSelection,eventStore:e.eventStore,eventUiBases:e.eventUiBases,eventSelection:e.eventSelection,eventDrag:e.eventDrag,eventResize:e.eventResize,resourceStore:e.resourceStore,nextDayThreshold:r.options.nextDayThreshold,rowInnerHeights:t.rowSyncHeights,onSlatCoords:this.handleSlatCoords,onRowCoords:this.handleRowCoords,onScrollLeftRequest:this.handleScrollLeftRequest,onRowHeightChange:t.reportRowHeightChange})}))}renderSpreadsheetRows(e,t,r){return e.map((e,o)=>e.group?s.createElement(S,{key:e.id,id:e.id,spreadsheetColCnt:t.length,isExpanded:e.isExpanded,group:e.group,innerHeight:r[o]||""}):e.resource?s.createElement(E,{key:e.id,colSpecs:t,rowSpans:e.rowSpans,depth:e.depth,isExpanded:e.isExpanded,hasChildren:e.hasChildren,resource:e.resource,innerHeight:r[o]||""}):null)}componentDidMount(){this.renderedRowNodes=this.rowNodes,this.scrollResponder=this.context.createScrollResponder(this.handleScrollRequest)}getSnapshotBeforeUpdate(){return this.props.forPrint?{}:{resourceScroll:this.queryResourceScroll()}}componentDidUpdate(e,t,r){this.renderedRowNodes=this.rowNodes,this.scrollResponder.update(e.dateProfile!==this.props.dateProfile),r.resourceScroll&&this.handleScrollRequest(r.resourceScroll)}componentWillUnmount(){this.scrollResponder.detach()}computeFallbackSlotMinWidth(e){return Math.max(30,(this.state.slotCushionMaxWidth||0)/e.slotsPerLabel)}queryResourceScroll(){let{rowCoords:e,renderedRowNodes:t}=this;if(e){let r=this.layoutRef.current,o=e.bottoms,n=r.getResourceScroll(),l={};for(let e=0;e<o.length;e+=1){let r=t[e],s=o[e]-n;if(s>0){l.rowId=r.id,l.fromBottom=s;break}}return l}return null}}function T(e){let t={};for(let r=0;r<e.length;r+=1)t[e[r].id]=r;return t}function G(e,t,r=""){return e.map((e,o)=>({className:e.isMain?"fc-main-col":"",width:t[o]||e.width||r}))}function k(e){for(let t of e){if(t.group)return!0;if(t.resource&&t.hasChildren)return!0}return!1}function A(e){let t=e.resourceAreaColumns||[],r=null;t.length?e.resourceAreaHeaderContent&&(r={headerClassNames:e.resourceAreaHeaderClassNames,headerContent:e.resourceAreaHeaderContent,headerDidMount:e.resourceAreaHeaderDidMount,headerWillUnmount:e.resourceAreaHeaderWillUnmount}):t.push({headerClassNames:e.resourceAreaHeaderClassNames,headerContent:e.resourceAreaHeaderContent,headerDefault:()=>"Resources",headerDidMount:e.resourceAreaHeaderDidMount,headerWillUnmount:e.resourceAreaHeaderWillUnmount});let o=[],n=[],l=[],s=!1;for(let r of t)r.group?n.push(Object.assign(Object.assign({},r),{cellClassNames:r.cellClassNames||e.resourceGroupLabelClassNames,cellContent:r.cellContent||e.resourceGroupLabelContent,cellDidMount:r.cellDidMount||e.resourceGroupLabelDidMount,cellWillUnmount:r.cellWillUnmount||e.resourceGroupLaneWillUnmount})):o.push(r);let i=o[0];if(i.isMain=!0,i.cellClassNames=i.cellClassNames||e.resourceLabelClassNames,i.cellContent=i.cellContent||e.resourceLabelContent,i.cellDidMount=i.cellDidMount||e.resourceLabelDidMount,i.cellWillUnmount=i.cellWillUnmount||e.resourceLabelWillUnmount,n.length)l=n,s=!0;else{let t=e.resourceGroupField;t&&l.push({field:t,labelClassNames:e.resourceGroupLabelClassNames,labelContent:e.resourceGroupLabelContent,labelDidMount:e.resourceGroupLabelDidMount,labelWillUnmount:e.resourceGroupLabelWillUnmount,laneClassNames:e.resourceGroupLaneClassNames,laneContent:e.resourceGroupLaneContent,laneDidMount:e.resourceGroupLaneDidMount,laneWillUnmount:e.resourceGroupLaneWillUnmount})}let d=e.resourceOrder||a.DEFAULT_RESOURCE_ORDER,c=[];for(let e of d){let t=!1;for(let r of l)if(r.field===e.field){r.order=e.order,t=!0;break}t||c.push(e)}return{superHeaderRendering:r,isVGrouping:s,groupSpecs:l,colSpecs:n.concat(o),orderSpecs:c}}M.addStateEquality({spreadsheetColWidths:l.isArraysEqual});l.injectStyles(".fc .fc-resource-timeline-divider{cursor:col-resize;width:3px}.fc .fc-resource-group{font-weight:inherit;text-align:inherit}.fc .fc-resource-timeline .fc-resource-group:not([rowspan]){background:var(--fc-neutral-bg-color)}.fc .fc-timeline-lane-frame{position:relative}.fc .fc-timeline-overlap-enabled .fc-timeline-lane-frame .fc-timeline-events{box-sizing:content-box;padding-bottom:10px}.fc-timeline-body-expandrows td.fc-timeline-lane{position:relative}.fc-timeline-body-expandrows .fc-timeline-lane-frame{position:static}.fc-datagrid-cell-frame-liquid{height:100%}.fc-liquid-hack .fc-datagrid-cell-frame-liquid{bottom:0;height:auto;left:0;position:absolute;right:0;top:0}.fc .fc-datagrid-header .fc-datagrid-cell-frame{align-items:center;display:flex;justify-content:flex-start;position:relative}.fc .fc-datagrid-cell-resizer{bottom:0;cursor:col-resize;position:absolute;top:0;width:5px;z-index:1}.fc .fc-datagrid-cell-cushion{overflow:hidden;padding:8px;white-space:nowrap}.fc .fc-datagrid-expander{cursor:pointer;opacity:.65}.fc .fc-datagrid-expander .fc-icon{display:inline-block;width:1em}.fc .fc-datagrid-expander-placeholder{cursor:auto}.fc .fc-resource-timeline-flat .fc-datagrid-expander-placeholder{display:none}.fc-direction-ltr .fc-datagrid-cell-resizer{right:-3px}.fc-direction-rtl .fc-datagrid-cell-resizer{left:-3px}.fc-direction-ltr .fc-datagrid-expander{margin-right:3px}.fc-direction-rtl .fc-datagrid-expander{margin-left:3px}");var z=t.createPlugin({name:"@fullcalendar/resource-timeline",premiumReleaseDate:"2023-05-25",deps:[u.default,p.default,h.default],initialView:"resourceTimelineDay",views:{resourceTimeline:{type:"timeline",component:M,needsResourceData:!0,resourceAreaWidth:"30%",resourcesInitiallyExpanded:!0,eventResizableFromStart:!0},resourceTimelineDay:{type:"resourceTimeline",duration:{days:1}},resourceTimelineWeek:{type:"resourceTimeline",duration:{weeks:1}},resourceTimelineMonth:{type:"resourceTimeline",duration:{months:1}},resourceTimelineYear:{type:"resourceTimeline",duration:{years:1}}}}),U={__proto__:null,ResourceTimelineView:M,ResourceTimelineLane:x,SpreadsheetRow:E};return t.globalPlugins.push(z),e.Internal=U,e.default=z,Object.defineProperty(e,"__esModule",{value:!0}),e}({},FullCalendar,FullCalendar.PremiumCommon,FullCalendar.Timeline,FullCalendar.Resource,FullCalendar.Internal,FullCalendar.Preact,FullCalendar.Timeline.Internal,FullCalendar.Resource.Internal,FullCalendar.ScrollGrid.Internal);