# 다이나믹 필드 확장 플러그인

### Description
- 다이나믹 필드 유형을 여러가지 추가 해줍니다.

### Enviroment
- [XpressEngine3](https://github.com/xpressengine/xpressengine "XE3 Git") 코어 3.0.13 이상이 필요합니다.
- 이 플러그인은 [다이나믹 팩토리](https://github.com/amuzcorp/dynamic_factory "DF Git") 플러그인과 호환됩니다.

# Features

### Components - Widgets

##### 지도 위젯

- 지도 필드를 통해 문서에 입력된 위치를 위젯으로 출력 해 줍니다.
- 카카오 스킨이 포함됩니다.

### Components - Dynamic Fields

##### 별점 스킨 (Rating Star)
- [XpressEngine3](https://github.com/xpressengine/xpressengine "XE3 Git") 기본필드인 Number 필드를 별점형태로 변경하여 줍니다.

##### 평점 계산 필드 (Rating)
- 같은 문서의 댓글에 추가된 Number 필드의 평점을 가져옵니다.
- 계산된 평점을 별점으로 출력하는 스킨이 포함되어 있습니다.

##### 섹션 필드 (Section Open / Section Close)

- 입력폼을 그룹으로 나누어주는 단순한 역할을 합니다.
- 이 필드는 반드시 Open 과 Close가 같이 추가되어야 합니다.
- 이 필드가 추가되면 출력순서에서 입력폼 순서를 반드시 지정 해 주어야 합니다.

#### 태그 필드 (Tag)

- 기본 태그 외에도 다른 종류의 태그를 추가하기 위한 태그필드를 추가할 수 있습니다.
- [다이나믹 팩토리](https://github.com/amuzcorp/dynamic_factory "DF Git") 플러그인과 호환됩니다.


#### 미디어 라이브러리 (Media Library)

- 미디러 라이브러리를 통해 갤러리 등을 구현할 수 있습니다. 에디터에서 사용되는 미디어 라이브러리와 분리됩니다.
- 미디어 제목,설명 등 메타정보를 활용할 수 있는 Media Table 스킨과 기본 라이브러리 스킨이 포함되어 있습니다.

#### 색상 선택기 (Color Picker)

- 컬러피커와 기본 스킨이 포함됩니다.
- Gradient 와 Alpha 값을 지원하는 컴포넌트가 포함되어 있습니다.

#### 설문 필드 (Survey)

- 향후 설명 추가

#### 테이블 편집기 (Table Editor)

- 자유롭게 표를 생성할 수 있는 필드가 추가됩니다.
- 향후 스타일링이 가능하도록 업데이트 될 예정입니다.

#### 카테고리 필드 (Category Load / Category Input)

###### 카테고리 불러오기

- 사전에 정의된 카테고리를 Select 또는 Radio, Checkbox 등의 옵션그룹으로 정의하여 입력필드를 생성합니다.
- 멀티셀렉트와 체크박스, 라디오버튼이 스킨으로 포함됩니다.

###### 카테고리 직접입력

- Select 또는 Radio, Checkbox 등의 옵션그룹을 key:value 형태로 직접 입력하여 입력필드를 생성합니다.
- 멀티셀렉트와 체크박스, 라디오버튼이 스킨으로 포함됩니다.

#### 아이콘 팩 (Icon Pack)

- 아이콘 입력기가 필드로 추가됩니다.
- XE 아이콘을 기반으로합니다.

#### 지도 입력기 (Map)

- 이 필드는 [통합 키 체인](https://github.com/amuzcorp/integrated_keychain "통합 키체인 깃 저장소")에 지도 키가 반드시 등록되어야 합니다.
- 지도가 생성되고 여러개의 마커를 생성할 수 있습니다.
- 카카오 지도 스킨과 네이버 지도 스킨이 포함됩니다.

#### 위치 입력기 (Location)

- 이 필드는 [통합 키 체인](https://github.com/amuzcorp/integrated_keychain "통합 키체인 깃 저장소")에 지도 키가 반드시 등록되어야 합니다.
- 주소 를 기반으로 주소 정보와 해당 주소의 위치 (Lat, Lng)값 등을 모두 한번에 저장 해 줍니다.
- 카카오 위치 스킨이 포함됩니다.

#### 인스턴스 선택기 (instance_selector)

- 메뉴아이템으로 등록된 인스턴스 ID를 호출 해 줍니다.
- 연관인스턴스 등으로 활용하여 외부인스턴스에서 선택된 인스턴스로 instance_route가 가능하도록 설계되었습니다.

#### 운영 시간 (Work Hour) - 현재 개발중

- 요일, 특정일자를 지정하고 일별로 운영시간을 지정할 수 있습니다.
- 현재 시간 또는 특정 시간이 지정된 시간에 Open 인지 Close인지를 반환하는 메소드가 포함됩니다.
- 운영시간을 요약한 테이블이 생성됩니다.

#### 날짜 입력기 (Calendar)

- 날짜를 입력받습니다.
- 단일 일자와 기간형 일자 스킨이 포함됩니다.

#### 시간 범위 입력기 (Time Range Picker)

- 시간 범위를 입력합니다.

#### HTML 직접 입력 (Html Landing)

- 입력 폼 중간중간에 html을 직접입력하여 안내 메세지를 보여줄 수 있습니다.
- 그 외에도 필요한 action 등을 추가하여 자유롭게 편집할 수 있습니다.
- 실제 입력 폼을 작성하는 입장에선 값을 변경하거나 저장할 수 없습니다.

***

# 향후 업데이트

* Map 및 Location Field 한 문서에 여러개 입력 불가능한부분 해결 (html entity 및 스크립트 개선 필요)
* WorkHour 필드 개발
* Table Editor 스타일링
* Table Editor 기본값 지정
