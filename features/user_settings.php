<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Enquiries : Settings Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="wrapper">
        <header>Settings Menu</header>
        <input type="radio" name="slider" checked id="basic">
        <input type="radio" name="slider" id="property-settings">
        <input type="radio" name="slider" id="prs-settings">
        <input type="radio" name="slider" id="mail-settings">
        <input type="radio" name="slider" id="mail-auto">
        <nav>
            <label for="basic" class="basic"><i class="fa fa-user"></i>Basic</label>
            <label for="property-settings" class="property-settings"><i class="fas fa-property-settings"></i>Property</label>
            <label for="prs-settings" class="prs-settings"><i class="fas fa-prs-settings"></i>PRS</label>
            <label for="mail-settings" class="mail-settings"><i class="far fa-envelope"></i>Mail</label>
            <label for="mail-auto" class="mail-auto"><i class="far fa-envelope"></i>Auto-Mail</label>
            <div class="slider"></div>
        </nav>
        <section>
            <div class="content content-1">
                <div class="title">Basic Settings</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero aspernatur nobis provident dolores molestias quia quisquam laborum, inventore quis, distinctioa, fugit repudiandae delectus sunt ipsam! Odio illo at quia doloremque fugit iops,
                    asperiores? Consectetur esse officia labore voluptatum blanditiis molestias dic voluptas est, minima unde sequi, praesentium dicta suscipit quisquam iure sed, nemo.</p>
            </div>
            <div class="content content-2">
                <div class="title">This is a property-settings content</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit amet. Possimus doloris nesciunt mollitia culpa sint itaque, vitae praesentium assumenda suscipit fugit doloremque adipisci doloribus, sequi facere itaque cumque accusamus, quam molestias
                    sed provident quibusdam nam deleniti. Autem eaque aut impedit eo nobis quia, eos sequi tempore! Facere ex repellendus, laboriosam perferendise. Enim quis illo harum, exercitationem nam totam fugit omnis natus quam totam, repudiandae
                    dolor laborum! Commodi?</p>
            </div>
            <div class="content content-3">
                <div class="title">This is a prs-settings content</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure, debitis nesciunt! Consectetur officiis, libero nobis dolorem pariatur quisquam temporibus. Labore quaerat neque facere itaque laudantium odit veniam consectetur numquam delectus
                    aspernatur, perferendis repellat illo sequi excepturi quos ipsam aliquid est consequuntur.</p>
            </div>
            <div class="content content-4">
                <div class="title">This is a mail-settings content</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim reprehenderit null itaq, odio repellat asperiores vel voluptatem magnam praesentium, eveniet iure ab facere officiis. Quod sequi vel, rem quam provident soluta nihil, eos.
                    Illo oditu omnis cumque praesentium voluptate maxime voluptatibus facilis nulla ipsam quidem mollitia! Veniam, fuga, possimus. Commodi, fugiat aut ut quorioms stu necessitatibus, cumque laborum rem provident tenetur.</p>
            </div>
            <div class="content content-5">
                <div class="title">This is a mail-auto content</div>
                <div class="holder">
                    <table width="100%">
                        <tr>
                            <td>Active Automatice Welcome Email</td>
                            <td>
                                <div>
                                    <input type="checkbox" />
                                    <span></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>----Test Option</td>
                            <td>
                                <div>
                                    <input type="checkbox" checked="" />
                                    <span></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Save Settings">
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </section>
    </div>

</body>

</html>

<style>
    .wrapper {
        max-width: 700px;
        width: 100%;
        margin: 200px auto;
        padding: 25px 30px 30px 30px;
        border-radius: 5px;
        background: #fff;
        box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .wrapper header {
        font-size: 30px;
        font-weight: 600;
        padding-bottom: 20px;
    }
    
    .wrapper nav {
        position: relative;
        width: 80%;
        height: 50px;
        display: flex;
        align-items: center;
    }
    
    .wrapper nav label {
        display: block;
        height: 100%;
        width: 100%;
        text-align: center;
        line-height: 50px;
        cursor: pointer;
        position: relative;
        z-index: 1;
        color: #17a2b8;
        font-size: 17px;
        border-radius: 5px;
        margin: 0 5px;
        transition: all 0.3s ease;
    }
    
    .wrapper nav label:hover {
        background: rgba(23, 162, 184, 0.3);
    }
    
    #basic:checked~nav label.basic,
    #property-settings:checked~nav label.property-settings,
    #prs-settings:checked~nav label.prs-settings,
    #mail-settings:checked~nav label.mail-settings,
    #mail-auto:checked~nav label.mail-auto {
        color: #fff;
    }
    
    nav label i {
        padding-right: 7px;
    }
    
    nav .slider {
        position: absolute;
        height: 100%;
        width: 20%;
        left: 0;
        bottom: 0;
        z-index: 0;
        border-radius: 5px;
        background: #17a2b8;
        transition: all 0.3s ease;
    }
    
    input[type="radio"] {
        display: none;
    }
    
    #property-settings:checked~nav .slider {
        left: 20%;
    }
    
    #prs-settings:checked~nav .slider {
        left: 40%;
    }
    
    #mail-settings:checked~nav .slider {
        left: 60%;
    }
    
    #mail-auto:checked~nav .slider {
        left: 80%;
    }
    
    section .content {
        display: none;
        background: #fff;
    }
    
    #basic:checked~section .content-1,
    #property-settings:checked~section .content-2,
    #prs-settings:checked~section .content-3,
    #mail-settings:checked~section .content-4,
    #mail-auto:checked~section .content-5 {
        display: block;
    }
    
    section .content .title {
        font-size: 21px;
        font-weight: 500;
        margin: 30px 0 10px 0;
    }
    
    section .content p {
        text-align: justify;
    }
    
    .holder {
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1);
        margin: 100px auto;
        padding: 30px 20px 20px;
        width: 400px;
    }
    
    td {
        border-bottom: 1px solid #f6f6f6;
        padding: 5px 10px;
    }
    
    td:nth-child(2) {
        text-align: right;
        width: 40px;
    }
    
    tr:last-child td {
        border: none;
        padding: 30px 10px 10px;
        text-align: center;
    }
    
    input[type=checkbox] {
        cursor: pointer;
        height: 30px;
        margin: 4px 0 0;
        position: absolute;
        opacity: 0;
        width: 30px;
        z-index: 2;
    }
    
    input[type=checkbox]+span {
        background: #e74c3c;
        border-radius: 50%;
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1);
        display: inline-block;
        height: 30px;
        margin: 4px 0 0;
        position: relative;
        width: 30px;
        transition: all .2s ease;
    }
    
    input[type=checkbox]+span::before,
    input[type=checkbox]+span::after {
        background: #fff;
        content: '';
        display: block;
        position: absolute;
        width: 4px;
        transition: all .2s ease;
    }
    
    input[type=checkbox]+span::before {
        height: 16px;
        left: 13px;
        top: 7px;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }
    
    input[type=checkbox]+span::after {
        height: 16px;
        right: 13px;
        top: 7px;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    
    input[type=checkbox]:checked+span {
        background: #2ecc71;
    }
    
    input[type=checkbox]:checked+span::before {
        height: 9px;
        left: 9px;
        top: 13px;
        -webkit-transform: rotate(-47deg);
        transform: rotate(-47deg);
    }
    
    input[type=checkbox]:checked+span::after {
        height: 15px;
        right: 11px;
        top: 8px;
    }
    
    input[type=submit] {
        background-color: #2ecc71;
        border: 0;
        border-radius: 4px;
        color: #FFF;
        cursor: pointer;
        display: inline-block;
        font-size: 16px;
        text-align: center;
        padding: 12px 20px 14px;
    }
</style>