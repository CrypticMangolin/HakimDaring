import { useState, useEffect } from 'react'
import { Button, Col, Container, Form, InputGroup, Modal, Row } from 'react-bootstrap'
import Header from './Header'
import ModelTestcase from '../model/ModelTestcase';
import ModelInputModal from '../model/ModelInputModal';
import ModelSoal from '../model/ModelSoal';
import TidakMemilikiHak from '../core/Data/ResponseGagal/TidakMemilikiHak';
import KesalahanInputData from '../core/Data/ResponseGagal/KesalahanInputData';
import KesalahanInternalServer from '../core/Data/ResponseGagal/KesalahanInternalServer';
import InterfaceSetTestcase from '../core/Testcase/Interface/InterfaceSetTestcase';
import SetTestcase from '../core/Testcase/SetTestcase';
import Testcase from '../core/Data/Testcase';
import BerhasilSetTestcase from '../core/Data/ResponseBerhasil/BerhasilSetTestcase';
import BatasanSoal from '../core/Data/BatasanSoal';
import InterfaceAmbilInformasiSoal from '../core/Soal/Interface/InterfaceAmbilInformasiSoal';
import { useNavigate, useParams } from 'react-router-dom';
import AmbilInformasiSoal from '../core/Soal/AmbilInformasiSoal';
import IDSoal from '../core/Data/IDSoal';
import InformasiSoal from '../core/Data/InformasiSoal';
import InterfaceAmbilSemuaTestcase from '../core/Testcase/Interface/InterfaceAmbilSemuaTestcase';
import AmbilSemuaTestcase from '../core/Testcase/AmbilSemuaTestcase';
import ModelStatistikSoal from '../model/ModelStatistikSoal';
import Soal from '../core/Data/Soal';
import InterfaceUbahSoal from '../core/Soal/Interface/InterfaceUbahSoal';
import UbahSoal from '../core/Soal/UbahSoal';
import SoalUbah from '../core/Data/SoalUbah';
import BerhasilUbahSoal from '../core/Data/ResponseBerhasil/BerhasilUbahSoal';

function HalamanUbahSoal() {

  const parameterURL = useParams()

  const navigate = useNavigate()

  const ambilInformasiSoal : InterfaceAmbilInformasiSoal = new AmbilInformasiSoal()
  const ambilSemuaTestcase : InterfaceAmbilSemuaTestcase = new AmbilSemuaTestcase()

  const ubahSoal : InterfaceUbahSoal = new UbahSoal()
  const setTestcase : InterfaceSetTestcase = new SetTestcase()

  const [daftarTestcase, setDaftarTestcase] = useState<ModelTestcase[]>([])
  const [popupInputString, setPopupInputString] = useState<boolean>(false)
  const [dataModalString, setDataModalString] = useState<ModelInputModal<string>>({
    testcase : null,
    namaAttribute : "",
    nilai : ""
  });

  const [dataStatistik, setDataStatistik] = useState<ModelStatistikSoal>({
    status : "",
    versi : 0,
    jumlahBerhasil : 0,
    jumlahSubmit : 0
  })

  const [dataSoal, setDataSoal] = useState<ModelSoal>({
    id : null,
    judul : "",
    soal : "",
    batasan_waktu_per_testcase_dalam_sekon : 1,
    batasan_waktu_semua_testcase_dalam_sekon : 10,
    batasan_memori_dalam_kb : 128000
  })

  function ambilDataSoalDanTestcase () {
    if (parameterURL.id_soal != null && !Number.isNaN(Number(parameterURL.id_soal))) {
      let idSoal = new IDSoal(Number(parameterURL.id_soal))
      ambilInformasiSoal.ambilInformasiSoal(idSoal, (hasil : any) => {
        if (hasil instanceof InformasiSoal) {
          (window as any).editor.setData(hasil.soal)

          setDataSoal({
            id : hasil.idSoal.id,
            judul : hasil.judul,
            soal : hasil.soal,
            batasan_waktu_per_testcase_dalam_sekon : hasil.batasanWaktuPerTestcase,
            batasan_waktu_semua_testcase_dalam_sekon : hasil.batasanWaktuTotal,
            batasan_memori_dalam_kb : hasil.batasanMemoriDalamKB
          })

          setDataStatistik({...dataStatistik, 
            status : hasil.status,
            versi : hasil.versi,
            jumlahSubmit : hasil.totalSubmit,
            jumlahBerhasil : hasil.totalBerhasil
          })
        }
        else if (hasil instanceof TidakMemilikiHak) {
          navigate("/")
        }
        else if (hasil instanceof KesalahanInputData) {

        }
        else if (hasil instanceof KesalahanInternalServer) {
          
        }
      })

      ambilSemuaTestcase.ambilSemuaTestcase(idSoal, (hasil : any) => {
        if (Array.isArray(hasil)) {
          let daftarTestcaseDariServer : ModelTestcase[] = []
          hasil.forEach(element => {
            if (element instanceof Testcase) {
              daftarTestcaseDariServer.push({
                testcase : element.testcase,
                jawaban : element.jawaban,
                publik : element.publik
              })
            }
          });
          setDaftarTestcase(hasil)
        }
      })
    }
    else {
      navigate("/")
    }
  }

  useEffect(() => {
    function loadScriptCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor") == null) {
          const script = document.createElement('script');
          script.src = "/ckeditor5-37.1.0/build/ckeditor.js";
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
        }
      });
    }
    function loadScriptCustomCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor-custom-build") == null) {
          const script = document.createElement('script');
          script.innerHTML = `
            let ckEditor = null
            
            ClassicEditor.create( '', {
                licenseKey: '',
            })
            .then( editor => {
                window.editor = editor;
                editor.model.document.on('change:data', () => {
                  window.perubahanCKEditor(editor.getData())
                })
                console.log("editor berhasil di load")
                document.getElementById("editor").appendChild(editor.ui.element)
            })
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: n96xuuc5ag4v-nk96buq2xi5g' );
                console.error( error );
            })`;
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor-custom-build"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
          document.getElementById("editor")?.appendChild((window as any).editor.ui.element)
        }
      });
    }

    async function loadCKEditor() {
      await loadScriptCKEditor()
      await loadScriptCustomCKEditor()
    }

    return () => {
      loadCKEditor()

      ambilDataSoalDanTestcase() 
    }
  }, []);

  const hapusTestcase = (testcase : ModelTestcase) => {
    setDaftarTestcase(daftarTestcase.filter(t => t !== testcase))
  }

  const tambahTestcase = (testcase : ModelTestcase) => {
    setDaftarTestcase(dataSebelumnya => [...dataSebelumnya, testcase])
  }

  const tutupPopupModalUntukTestcase = () => {
    setPopupInputString(false)
    setDataModalString({
      testcase : null,
      namaAttribute : "",
      nilai : ""
    })
  }

  const simpanInputString = () => {
    if (dataModalString != null) {
      (dataModalString.testcase as any)[dataModalString.namaAttribute] = dataModalString.nilai
    }
    tutupPopupModalUntukTestcase()
  }

  function perubahanCKEditor(tes : string) {
    setDataSoal({...dataSoal, soal : tes})
  }
  (window as any).perubahanCKEditor = perubahanCKEditor

  function convertModelTestcaseMenjadiTestcase(daftarModelTestcase : ModelTestcase[]) : Testcase[] {
    let hasil : Testcase[] = []
    for (let i = 0; i < daftarModelTestcase.length; i++) {
      hasil.push(new Testcase(
        daftarModelTestcase[i].testcase,
        daftarModelTestcase[i].jawaban,
        i + 1,
        daftarModelTestcase[i].publik
      ))
    }

    return hasil
  }

  function simpanSoal() {

    if (dataSoal.id != null) {
      ubahSoal.ubahSoal(
        new SoalUbah(
          new IDSoal(
            dataSoal.id
          ), 
          new Soal(
            dataSoal.judul,
            dataSoal.soal
          )
        ),
        (hasil : any) => {
          
          if (hasil instanceof BerhasilUbahSoal) {
            
          } 
          else if (hasil instanceof TidakMemilikiHak) {
  
          }
          else if (hasil instanceof KesalahanInputData) {
  
          }
          else if (hasil instanceof KesalahanInternalServer) {
  
          }
          console.log(hasil)
        }
      )
  
      setTestcase.setTestcase(
        new IDSoal(dataSoal.id), 
        new BatasanSoal(
          dataSoal.batasan_waktu_per_testcase_dalam_sekon, 
          dataSoal.batasan_waktu_semua_testcase_dalam_sekon,
          dataSoal.batasan_memori_dalam_kb
        ),
        convertModelTestcaseMenjadiTestcase(daftarTestcase),
        (hasil : any) => {
          if (hasil instanceof BerhasilSetTestcase) {
            console.log("Berhasil")
          }
          else {
            console.log(hasil)
          }
        } 
      )
    }

    ambilDataSoalDanTestcase()
  }


  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Row className='m-0 p-0'>
          <Col sm={12} md={8} lg={8} xl={8} className="d-flex flex-column m-0 p-2">
            <Row className='m-0 p-0 d-flex flex-column'>
              <Col className='m-0 p-0'>
                <Row className='m-0 mx-5 mb-4 p-0 d-flex flex-column'>
                  <p className='m-0 py-2 fs-4 fw-bold text-center'>Judul Soal</p>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='text' placeholder="Judul" className='m-2 py-1 text-center' value={dataSoal.judul} onChange={(e) => {
                      setDataSoal({...dataSoal, judul : e.target.value})
                    }}/>
                  </InputGroup>
                </Row>
              </Col>
              <Col className='m-0 p-0'>
                <Row className='m-0 p-0 pb-4 d-flex flex-column'>
                  <p className='m-0 py-2 fs-4 fw-bold text-center'>Soal</p>
                  <div id='editor' className="editor">
                  </div>
                </Row>
              </Col>
            </Row>
          </Col>
          <Col sm={12} md={4} lg={4} xl={4} className="d-flex flex-column m-0 p-2">
            <Row className='m-0 p-0'>
              <p className='m-0 p-0 fs-4 fw-bold text-center'>Buat Soal</p>
              <Button variant='dark' className='m-2 mb-4' onClick={simpanSoal}>
                Tekan Untuk Menyimpan Perubahan
              </Button>
              <p className='m-0 p-0 py-2 fs-6 text-start'>*Perubahan pada batasan soal atau testcase akan membaut versi soal meningkat yang akan menyebabkan jumlah submit dan submit berhasil kembali menjadi 0</p>

              <p className='m-0 p-0 py-2 fs-4 fw-bold text-center'>Status</p>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Status</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataStatistik.status}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Versi</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataStatistik.versi}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Jumlah Submit</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataStatistik.jumlahSubmit}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Submit Berhasil</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataStatistik.jumlahBerhasil}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Persentase Keberhasilan</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataStatistik.jumlahSubmit > 0 ? dataStatistik.jumlahBerhasil / dataStatistik.jumlahSubmit : 0}%</p>
                </Col>
              </Col>

              <p className='m-0 p-0 py-2 fs-4 fw-bold text-center'>Batasan Sumber Daya</p>
              <Col xs={12} className='m-0 p-0 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Waktu per Testcase" className='m-2 py-1 text-center fs-6' value={dataSoal.batasan_waktu_per_testcase_dalam_sekon} onChange={(e) => {
                      setDataSoal({...dataSoal, batasan_waktu_per_testcase_dalam_sekon : Number(e.target.value)})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>sekon</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Waktu Semua Testcase" className='m-2 py-1 text-center fs-6' value={dataSoal.batasan_waktu_semua_testcase_dalam_sekon} onChange={(e) => {
                      setDataSoal({...dataSoal, batasan_waktu_semua_testcase_dalam_sekon : Number(e.target.value)})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>sekon</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 pb-4 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Memori" className='m-2 py-1 text-center fs-6' value={dataSoal.batasan_memori_dalam_kb} onChange={(e) => {
                      setDataSoal({...dataSoal, batasan_memori_dalam_kb : Number(e.target.value)})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>KB</p>
                </Col>
              </Col>
              <p className='m-0 p-0 pb-2 fs-4 fw-bold text-center'>Testcase</p>
              <p className='m-0 p-0 pb-2 fs-6 text-start'>Total Testcase: {daftarTestcase.length}</p>
              <Row className='m-0 p-0'>
                {
                  daftarTestcase.map((testcase : ModelTestcase, index : number) =>{
                    return (
                      <Col className='m-0 p-0' xs={12} key={"daftarTestcase: " + index}>
                        <Col xs={12} className='m-1 p-0 d-flex flex-row'>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0'
                              onClick={() => {
                                setDataModalString({
                                  "testcase" : testcase,
                                  namaAttribute : "testcase",
                                  nilai : testcase.testcase
                                })

                                setPopupInputString(true)
                              }}
                            >
                              Atur Testcase
                            </Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' 
                              onClick={() => {
                                setDataModalString({
                                  "testcase" : testcase,
                                  namaAttribute : "jawaban",
                                  nilai : testcase.jawaban
                                })

                                setPopupInputString(true)
                              }}
                            >
                              Atur Jawaban
                            </Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' onClick={
                              () => {
                                testcase.publik = !testcase.publik
                                if (daftarTestcase.filter((element) => element.publik).length > 5) {
                                  testcase.publik = false
                                }
                                setDaftarTestcase([...daftarTestcase])
                              }
                            }>
                              {testcase.publik ? "Publik" : "Private"}
                            </Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' onClick={() => {
                               hapusTestcase(testcase)
                            }}>
                              Hapus
                            </Button>
                          </Col>
                        </Col>
                      </Col>
                    )
                  })
                }
                
                <Modal show={popupInputString} onHide={tutupPopupModalUntukTestcase}>
                  <Modal.Header closeButton>
                    <Modal.Title>{dataModalString.namaAttribute}</Modal.Title>
                  </Modal.Header>
                  <InputGroup>
                    <Form.Control 
                      type='text'
                      as="textarea"
                      placeholder={"Tuliskan " + dataModalString.namaAttribute} 
                      onChange={(e) => {
                        setDataModalString({...dataModalString, nilai : e.target.value})
                      }}
                      value={dataModalString.nilai}
                      className='mx-2 p-2'
                    />
                  </InputGroup>
                  <Modal.Footer>
                    <Button variant="light" className='border border-dark' onClick={tutupPopupModalUntukTestcase}>
                      Batalkan
                    </Button>
                    <Button variant="dark" onClick={simpanInputString}>
                      Simpan
                    </Button>
                  </Modal.Footer>
                </Modal>
              </Row>
              <Button variant='dark' onClick={() => {
                if (daftarTestcase.length < 20) {
                  tambahTestcase({
                    testcase : "",
                    jawaban : "",
                    publik : false
                  })
                }
              }}>
                Tambah Testcase
              </Button>
            </Row>
          </Col>
        </Row>
      </Container>
    </>
  )

}

export default HalamanUbahSoal