<template>
  <div class="container mt-4 col-md-4 bg-body-secondary ">
    <h2 class="text-center mb-3">เพิ่มสินค้า</h2>
    <form @submit.prevent="addData">
      <div class="mb-2">
        <input v-model="product.product_name" class="form-control" placeholder="ชื่อสินค้า"  required />
      </div>
      <div class="mb-2">
        <input v-model="product.description" class="form-control" placeholder="รายละเอียดสินค้า"  required />
      </div>
      <div class="mb-2">
        <input  v-model="product.price" class="form-control" placeholder="ราคา"  required />
      </div>
      <div class="mb-2">
        <input  v-model="product.stock" class="form-control"  placeholder="จำนวน"  required />
      </div>
      <!--เพิ่มรูปภาพ-->
       <div class="mb-2">
     <!-- ใช้ @change อ่านไฟล์ -->
        <input type="file" @change="onFileChange" ref="fileInput" required />
      </div>
     
      <div class="text-center mt-4 ">
      <button type="submit" class="btn btn-primary mb-4">บันทึก</button> &nbsp;
      <button type="reset" class="btn btn-secondary mb-4">ยกเลิก</button>
      </div>
    </form>

    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      product: {
        product_name: "",
        description: "",
        price: "",
        image: null, // เก็บไฟล์ object
        stock: ""
      },
      message: ""
    };
  },

  methods: {

//เพิ่มเกี่ยวกับรูป
    onFileChange(e) {
      this.product.image = e.target.files[0];
    },
//-------
    async addData() {   
      try {

  // เพิ่มเกี่ยวกับรูป ใช้ FormData สำหรับส่ง text + file
        const formData = new FormData();
        formData.append("product_name", this.product.product_name);
        formData.append("description", this.product.description);
        formData.append("price", this.product.price);
        formData.append("stock", this.product.stock);
        formData.append("image", this.product.image);
//---------------
        const res = await fetch("http://localhost/project-vue01/php_api/add_product.php", {
          method: "POST",
          body: formData,   //เพิ่มเกี่ยวกับรูป
          //headers: { "Content-Type": "application/json" },
          //body: JSON.stringify(this.product)
        });

        const data = await res.json();
        this.message = data.message;

        if (data.success) {
          // ✅ เคลียร์ข้อมูลใน textbox หลังบันทึกสำเร็จ
          this.product = { product_name: "", description: "", price: "", image:null, stock: "" };
        }
this.$refs.fileInput.value = "";
      } catch (err) {
        this.message = "เกิดข้อผิดพลาด: " + err.message;
      }
    }
  }
}
</script>
